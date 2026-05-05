<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Venue;
use App\Models\TimeSlotConfig;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusMail;

class AdminController extends Controller
{
    public function index()
    {
        // Auto-clean expired bookings logic
        // Booking::where('status', 'pending')->where('created_at', '<', now()->subHours(1))->delete();

        $totalBookings = Booking::count();
        $totalPendapatan = Booking::where('status', 'paid')->sum('total_price');
        $totalUser = User::count();
        
        $bookings = Booking::with(['venue', 'court'])->latest()->get();
        $users = User::latest()->limit(5)->get();

        // Data Grafik Pendapatan Bulanan (Tahun Berjalan)
        $monthlyRevenue = Booking::where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        
        $chartData = array_fill(1, 12, 0);
        foreach ($monthlyRevenue as $month => $total) {
            $chartData[$month] = (float)$total;
        }
        $chartData = array_values($chartData);

        // Data Lapangan Terpopuler
        $topVenues = Booking::where('status', 'paid')
            ->select('venue_id', \Illuminate\Support\Facades\DB::raw('count(*) as total_bookings'))
            ->groupBy('venue_id')
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->with('venue')
            ->get();

        // 1. Jadwal Terdekat (Mulai dalam 1 jam ke depan)
        $now = now();
        $oneHourLater = now()->copy()->addHour();
        
        $upcomingBookings = Booking::with(['venue', 'court'])
            ->where('status', 'paid')
            ->whereDate('booking_date', $now->toDateString())
            ->get()
            ->filter(function($booking) use ($now, $oneHourLater) {
                foreach ($booking->time_slots as $slot) {
                    $startTime = explode(' - ', $slot)[0];
                    try {
                        $startDateTime = \Carbon\Carbon::parse($booking->booking_date . ' ' . $startTime);
                        if ($startDateTime->isBetween($now, $oneHourLater)) {
                            return true;
                        }
                    } catch (\Exception $e) { continue; }
                }
                return false;
            });

        // 2. Ringkasan Metode Bayar
        $paymentSummary = Booking::where('status', 'paid')
            ->select('payment_type', \Illuminate\Support\Facades\DB::raw('SUM(total_price) as total'))
            ->groupBy('payment_type')
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings', 'totalPendapatan', 'totalUser', 'bookings', 'users', 'chartData', 
            'topVenues', 'upcomingBookings', 'paymentSummary'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,dp,paid,cancelled'
        ]);

        $booking = Booking::with('user')->findOrFail($id);
        $oldStatus = $booking->status;
        $newStatus = $request->status;

        $booking->update(['status' => $newStatus]);

        // Send Email Notification if status changed
        if ($oldStatus !== $newStatus && $booking->user && $booking->user->email) {
            if ($newStatus === 'paid') {
                $ticketUrl = route('booking.ticket', $booking->id);
                $statusMessage = "Pembayaran Anda telah DIKONFIRMASI! 🎉\n\nTiket elektronik Anda sudah siap. Silakan kunjungi link berikut untuk melihat e-tiket:\n" . $ticketUrl . "\n\nTunjukkan e-tiket ini saat tiba di lokasi. Selamat bermain!";
            } else {
                $statusMessage = "Status pesanan Anda telah diperbarui menjadi: " . strtoupper($newStatus);
            }
            try {
                Mail::to($booking->user->email)->send(new BookingStatusMail($booking, $statusMessage));
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function venuesIndex()
    {
        $venues = Venue::with('courts')->latest()->get();
        return view('admin.venues_index', compact('venues'));
    }

    public function createVenue()
    {
        return view('admin.create_venue');
    }

    public function storeVenue(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'contact_phone' => 'nullable|string|max:20',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'facilities' => 'nullable|array',
            'operation_start_time' => 'required|date_format:H:i',
            'operation_end_time' => 'required|date_format:H:i',
            'court_name' => 'required|array|min:1',
            'court_type' => 'required|array|min:1',
            'court_price' => 'required|array|min:1',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('venues', 'public');
        }

        // Set venue type and price to the first court's info for backward compatibility
        $defaultType = $request->court_type[0] ?? 'Sintetis';
        $defaultPrice = $request->court_price[0] ?? 100000;

        $venue = Venue::create([
            'name' => $request->name,
            'address' => $request->address,
            'contact_phone' => $request->contact_phone,
            'type' => $defaultType,
            'price' => $defaultPrice,
            'image' => $imagePath,
            'facilities' => $request->facilities,
            'operation_start_time' => $request->operation_start_time,
            'operation_end_time' => $request->operation_end_time,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Auto-generate time slot configs berdasarkan jam operasional
        $startHour = (int) substr($request->operation_start_time, 0, 2);
        $endHour = (int) substr($request->operation_end_time, 0, 2);

        // Jika jam tutup 00:00, artinya sampai tengah malam (24)
        if ($endHour == 0) {
            $endHour = 24;
        }

        $slotCount = 0;
        
        // Loop through each submitted court
        foreach ($request->court_name as $index => $cName) {
            $cType = $request->court_type[$index] ?? 'Sintetis';
            $cPrice = $request->court_price[$index] ?? 100000;
            
            $cImagePath = null;
            if ($request->hasFile('court_image') && isset($request->file('court_image')[$index])) {
                $cImagePath = $request->file('court_image')[$index]->store('courts', 'public');
            } elseif ($imagePath) {
                $cImagePath = $imagePath; // fallback to venue image if specific court image not provided
            }

            $court = \App\Models\Court::create([
                'venue_id' => $venue->id,
                'name' => $cName,
                'type' => $cType,
                'price' => $cPrice,
                'image' => $cImagePath,
            ]);

            for ($h = $startHour; $h < $endHour; $h++) {
                $slotStart = sprintf('%02d:00', $h);
                $slotEnd = sprintf('%02d:00', ($h + 1) % 24);

                TimeSlotConfig::create([
                    'venue_id' => $venue->id,
                    'court_id' => $court->id,
                    'start_time' => $slotStart,
                    'end_time' => $slotEnd,
                    'price' => $cPrice,
                    'is_active' => true,
                ]);
                $slotCount++;
            }
        }

        return redirect()->route('admin.dashboard')->with('success', "Data GOR \"{$venue->name}\" berhasil ditambahkan dengan ".count($request->court_name)." lapangan & {$slotCount} slot jam otomatis!");
    }

    public function manageCourts($id)
    {
        $venue = Venue::findOrFail($id);
        $courts = \App\Models\Court::where('venue_id', $id)->get();

        return view('admin.manage_courts', compact('venue', 'courts'));
    }

    public function storeCourt(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $venue = Venue::findOrFail($id);
        
        $cImagePath = $venue->image; // Default fallback
        if ($request->hasFile('image')) {
            $cImagePath = $request->file('image')->store('courts', 'public');
        }

        $court = \App\Models\Court::create([
            'venue_id' => $venue->id,
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'image' => $cImagePath,
        ]);

        return back()->with('success', "Lapangan {$court->name} berhasil ditambahkan!");
    }

    public function deleteCourt($id)
    {
        $court = \App\Models\Court::findOrFail($id);
        $court->delete();

        return back()->with('success', 'Lapangan berhasil dihapus!');
    }

    public function editVenue($id)
    {
        $venue = Venue::with('courts')->findOrFail($id);
        $courts = $venue->courts;
        return view('admin.edit_venue', compact('venue', 'courts'));
    }

    public function updateVenue(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'contact_phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'facilities' => 'nullable|array',
            'operation_start_time' => 'required|date_format:H:i',
            'operation_end_time' => 'required|date_format:H:i',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $venue = Venue::findOrFail($id);
        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($venue->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($venue->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($venue->image);
            }
            $data['image'] = $request->file('image')->store('venues', 'public');
        }

        $venue->update($data);

        return redirect()->route('admin.venues.index')->with('success', "Data GOR \"{$venue->name}\" berhasil diperbarui!");
    }

    public function updateCourt(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $court = \App\Models\Court::findOrFail($id);
        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            // Delete old image if exists and it's not the venue's default image
            if ($court->image && $court->image !== $court->venue->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($court->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($court->image);
            }
            $data['image'] = $request->file('image')->store('courts', 'public');
        }

        $court->update($data);

        return back()->with('success', "Detail lapangan {$court->name} berhasil diperbarui!");
    }

    public function manageTimeSlots($id)
    {
        $court = \App\Models\Court::with('venue')->findOrFail($id);
        $venue = $court->venue;

        $timeSlots = TimeSlotConfig::where('court_id', $id)
            ->orderBy('start_time')
            ->get();

        return view('admin.manage_timeslots', compact('venue', 'court', 'timeSlots'));
    }

    public function updateCourtHours(Request $request, $id)
    {
        $request->validate([
            'operation_start_time' => 'required|date_format:H:i',
            'operation_end_time' => 'required|date_format:H:i',
            'default_price' => 'required|numeric|min:0',
        ]);

        $court = \App\Models\Court::findOrFail($id);
        $venue = $court->venue;
        
        $court->update([
            'price' => $request->default_price,
        ]);

        $startHour = (int) substr($request->operation_start_time, 0, 2);
        $endHour = (int) substr($request->operation_end_time, 0, 2);
        
        if ($endHour == 0) {
            $endHour = 24;
        }

        $validStartTimes = [];
        for ($h = $startHour; $h < $endHour; $h++) {
            $validStartTimes[] = sprintf('%02d:00:00', $h);
        }
        TimeSlotConfig::where('court_id', $id)
            ->whereNotIn('start_time', $validStartTimes)
            ->delete();

        $defaultPrice = $request->default_price;
        $addedCount = 0;

        for ($h = $startHour; $h < $endHour; $h++) {
            $slotStart = sprintf('%02d:00', $h);
            $slotEnd = sprintf('%02d:00', ($h + 1) % 24);

            $exists = TimeSlotConfig::where('court_id', $id)
                ->where('start_time', $slotStart)
                ->exists();

            if (!$exists) {
                TimeSlotConfig::create([
                    'venue_id' => $venue->id,
                    'court_id' => $id,
                    'start_time' => $slotStart,
                    'end_time' => $slotEnd,
                    'price' => $defaultPrice,
                    'is_active' => true,
                ]);
                $addedCount++;
            }
        }

        $totalSlots = $endHour - $startHour;
        return back()->with('success', "Jam operasional diperbarui! Total {$totalSlots} slot ({$addedCount} baru ditambahkan, sisanya tetap dipertahankan).");
    }

    public function bulkUpdatePrice(Request $request, $id)
    {
        $request->validate([
            'range_start' => 'required|date_format:H:i',
            'range_end' => 'required|date_format:H:i',
            'range_price' => 'required|numeric|min:0',
        ]);

        $startHour = (int) substr($request->range_start, 0, 2);
        $endHour = (int) substr($request->range_end, 0, 2);
        if ($endHour == 0) $endHour = 24;

        $targets = [];
        for ($h = $startHour; $h < $endHour; $h++) {
            $targets[] = sprintf('%02d:00:00', $h % 24);
        }

        $updated = TimeSlotConfig::where('court_id', $id)
            ->whereIn('start_time', $targets)
            ->update(['price' => $request->range_price]);

        $label = $request->range_start . ' - ' . $request->range_end;
        return back()->with('success', "Harga {$updated} slot ({$label}) berhasil diubah ke Rp " . number_format($request->range_price, 0, ',', '.'));
    }

    public function storeTimeSlot(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
        ]);

        $court = \App\Models\Court::findOrFail($id);

        $exists = TimeSlotConfig::where('court_id', $id)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Slot jam ' . $request->start_time . ' sudah ada untuk lapangan ini!');
        }

        TimeSlotConfig::create([
            'venue_id' => $court->venue_id,
            'court_id' => $id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'price' => $request->price,
            'is_active' => true,
        ]);

        return back()->with('success', 'Slot jam berhasil ditambahkan!');
    }

    public function updateTimeSlot(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $slot = TimeSlotConfig::findOrFail($id);
        $slot->update([
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);

        return back()->with('success', 'Slot jam berhasil diperbarui!');
    }

    public function deleteTimeSlot($id)
    {
        $slot = TimeSlotConfig::findOrFail($id);
        $slot->delete();

        return back()->with('success', 'Slot jam berhasil dihapus!');
    }

    public function reports(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));
        $status = $request->get('status');

        $query = Booking::with(['venue', 'court', 'user'])
            ->whereDate('booking_date', '>=', $startDate)
            ->whereDate('booking_date', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();
        
        $totalRevenue = $bookings->where('status', 'paid')->sum('total_price');
        $totalBookings = $bookings->count();
        $paidBookings = $bookings->where('status', 'paid')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $cancelledBookings = $bookings->where('status', 'cancelled')->count();
        
        $revenueByVenue = $bookings->where('status', 'paid')
            ->groupBy('venue_id')
            ->map(function ($items) {
                return [
                    'name' => $items->first()->venue->name ?? 'Dihapus',
                    'total' => $items->sum('total_price')
                ];
            })->values();

        $statusDist = [
            'Lunas' => $paidBookings,
            'Pending' => $pendingBookings,
            'DP' => $bookings->where('status', 'dp')->count(),
            'Batal' => $cancelledBookings,
        ];

        $dailyRevenue = $bookings->where('status', 'paid')
            ->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->booking_date)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->sum('total_price');
            });
            
        $trendData = [];
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $trendData[] = [
                'date' => $date->format('d M'),
                'total' => $dailyRevenue->get($dateString, 0)
            ];
        }

        return view('admin.reports', compact(
            'bookings', 'totalRevenue', 'totalBookings', 'paidBookings', 'startDate', 'endDate', 'status',
            'revenueByVenue', 'statusDist', 'trendData', 'pendingBookings', 'cancelledBookings'
        ));
    }

    public function exportReports(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));
        $status = $request->get('status');

        $query = Booking::with(['venue', 'court', 'user'])
            ->whereDate('booking_date', '>=', $startDate)
            ->whereDate('booking_date', '<=', $endDate);

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();

        $fileName = 'laporan_booking_' . $startDate . '_ke_' . $endDate . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Booking', 'Customer', 'WhatsApp', 'Venue', 'Lapangan', 'Tanggal Main', 'Jam', 'Total Harga', 'Status', 'Metode Bayar', 'Tgl Pesan'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $row['ID Booking']  = $booking->order_id;
                $row['Customer']    = $booking->customer_name;
                $row['WhatsApp']    = $booking->customer_phone;
                $row['Venue']       = $booking->venue->name ?? 'N/A';
                $row['Lapangan']    = $booking->court->name ?? 'N/A';
                $row['Tanggal Main']= $booking->booking_date;
                $row['Jam']         = implode(', ', $booking->time_slots);
                $row['Total Harga'] = $booking->total_price;
                $row['Status']      = strtoupper($booking->status);
                $row['Metode Bayar']= $booking->payment_type ?? '-';
                $row['Tgl Pesan']   = $booking->created_at->format('Y-m-d H:i');

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}