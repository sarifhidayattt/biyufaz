<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue; 
use App\Models\Booking; 
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusMail;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua lapangan
     * Digunakan oleh route: /venues
     */
    public function index(Request $request)
    {
        $query = Venue::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'cheap') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'expensive') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->latest();
        }

        $venues = $query->get();
        return view('venues', compact('venues'));
    }

    /**
     * Menampilkan halaman form booking
     * Sesuai dengan Route: /booking/{id}
     */
    public function show($id)
    {
        // Admin diperbolehkan melihat halaman ini untuk memantau slot
        $venue = Venue::with('courts.timeSlotConfigs')->findOrFail($id);
        return view('booking', compact('venue'));
    }

    /**
     * Menyimpan data booking awal (status pending)
     * Sesuai dengan Route: /booking/store
     */
    public function store(Request $request)
    {
        // Admin tidak boleh melakukan booking
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan booking lapangan.');
        }

        $request->validate([
            'venue_id'       => 'required|exists:lapangan,id',
            'court_id'       => 'required|exists:detail_lapangan,id',
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string',
            'booking_date'   => 'required|date',
            'time_slots'     => 'required|array',
            'time_slots.*'   => 'required|string', // Pastikan setiap item adalah string
            'total_price'    => 'required|numeric',
            'payment_option' => 'required|in:full,dp'
        ]);

        $totalPrice = floatval($request->total_price);
        $venueId = $request->venue_id;
        $courtId = $request->court_id;
        $bookingDate = $request->booking_date;
        $requestedSlots = $request->time_slots;

        // Fetch court type manually if needed or retrieve it safely
        $court = \App\Models\Court::findOrFail($courtId);

        DB::beginTransaction();
        try {
            // --- Validasi Anti Bentrok PER LAPANGAN ---
            $existingBookings = Booking::where('venue_id', $venueId)
                ->where('court_id', $courtId)
                ->where('booking_date', $bookingDate)
                ->whereIn('status', ['paid', 'confirmed', 'pending'])
                ->where(function ($query) use ($requestedSlots) {
                    foreach ($requestedSlots as $slot) {
                        $query->orWhereJsonContains('time_slots', $slot);
                    }
                })
                ->lockForUpdate() // Kunci baris untuk mencegah race condition
                ->get();

            if ($existingBookings->isNotEmpty()) {
                // Temukan slot mana yang bentrok
                $bookedSlots = $existingBookings->pluck('time_slots')->flatten()->unique()->toArray();
                $conflicts = array_intersect($requestedSlots, $bookedSlots);
                DB::rollBack();
                return back()->with('error', 'Gagal! Slot ' . implode(', ', $conflicts) . ' sudah tidak tersedia. Silakan pilih slot lain.');
            }

            $booking = Booking::create([
                'user_id'        => auth()->id(),
                'venue_id'       => $venueId,
                'court_id'       => $courtId,
                'court_type'     => $court->type, // Backward compatibility
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'booking_date'   => $bookingDate, 
                'time_slots'     => $requestedSlots,
                'total_price'    => $totalPrice,
                'payment_type'   => $request->payment_option,
                'status'         => 'pending',
                'amount_paid'    => 0
            ]);

            // Buat Order ID unik untuk Payment Gateway
            $orderId = 'ORDER-' . $booking->id . '-' . time();
            $booking->order_id = $orderId;
            $booking->save();

            DB::commit();

            // Kirim Email Notifikasi Pembuatan Pesanan
            try {
                if (auth()->user() && auth()->user()->email) {
                    $statusMessage = "Pesanan Anda berhasil dibuat! Segera lakukan pembayaran agar slot lapangan Anda terkunci. Jika tidak ada pembayaran dalam waktu yang ditentukan, pesanan dapat dibatalkan otomatis.";
                    Mail::to(auth()->user()->email)->send(new BookingStatusMail($booking, $statusMessage));
                }
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email: ' . $e->getMessage());
            }

            // Arahkan ke halaman pembayaran sesuai Route di web.php
            return redirect()->route('booking.payment', $booking->id);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Booking Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem. Gagal memproses booking.');
        }
    }

    /**
     * Menampilkan halaman pembayaran manual (QRIS / Transfer Bank)
     * Sesuai dengan Route: /booking/payment/{id}
     */
    public function payment($id)
    {
        $booking = Booking::with('venue')->findOrFail($id);
        
        // Hitung nominal yang harus dibayar berdasarkan pilihan Lunas/DP
        $amountToPay = ($booking->payment_type === 'dp') 
            ? ($booking->total_price * 0.5) 
            : $booking->total_price;

        // Ambil metode pembayaran manual (QRIS, Transfer Bank, dll)
        $manualMethods = \App\Models\PaymentMethod::where('is_active', true)->get();

        return view('booking_payment', [
            'booking' => $booking,
            'amountToPay' => $amountToPay,
            'manualMethods' => $manualMethods
        ]);
    }



    /**
     * Halaman sukses setelah pembayaran selesai
     */
    public function success($id)
    {
        $booking = Booking::with('venue')->findOrFail($id);
        return view('booking_success', compact('booking'));
    }

    /**
     * Menampilkan E-Tiket setelah pembayaran dikonfirmasi admin
     * Hanya bisa diakses jika status booking = 'paid'
     */
    public function ticket($id)
    {
        $booking = Booking::with(['venue', 'court'])->findOrFail($id);

        // Pastikan hanya pemilik booking yang bisa lihat tiket
        if ($booking->user_id !== auth()->id() && $booking->customer_phone !== auth()->user()->phone) {
            return redirect()->route('booking.history')->with('error', 'Akses ditolak.');
        }

        // Hanya tampilkan tiket jika sudah dibayar/dikonfirmasi
        if (!in_array($booking->status, ['paid', 'confirmed'])) {
            return redirect()->route('booking.history')->with('error', 'Tiket belum tersedia. Pembayaran Anda belum dikonfirmasi oleh admin.');
        }

        return view('booking_ticket', compact('booking'));
    }

    /**
     * API untuk mengecek status booking secara realtime
     * Digunakan untuk auto-redirect dari halaman pembayaran ke tiket
     */
    public function checkStatus($id)
    {
        $booking = Booking::select('id', 'status')->findOrFail($id);
        return response()->json([
            'status' => $booking->status
        ]);
    }

    /**
     * Riwayat Booking User
     */
    public function history()
    {
        if (!auth()->check()) return redirect('/login');
        
        $userPhone = auth()->user()->phone;

        $bookings = Booking::where('customer_phone', $userPhone)
            ->with('venue')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('history', compact('bookings'));
    }

    /**
     * Membatalkan pesanan (Strict Rules)
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Pastikan hanya pemilik yang bisa membatalkan (berdasarkan phone atau user_id)
        if ($booking->user_id !== auth()->id() && $booking->customer_phone !== auth()->user()->phone) {
            return back()->with('error', 'Akses ditolak.');
        }

        // Aturan ketat: Hanya bisa batal jika status pending atau dp
        if (!in_array($booking->status, ['pending', 'dp'])) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan karena statusnya sudah ' . strtoupper($booking->status) . '.');
        }

        // Aturan ketat: Harus H-1 dari tanggal main
        $bookingDate = \Carbon\Carbon::parse($booking->booking_date)->startOfDay();
        $now = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->startOfDay();

        if ($now->greaterThanOrEqualTo($bookingDate)) {
            return back()->with('error', 'Pembatalan gagal! Anda hanya bisa membatalkan pesanan maksimal H-1 (sehari sebelum jadwal main).');
        }

        // Jika lolos semua pengecekan, batalkan
        $booking->update([
            'status' => 'cancelled'
        ]);

        $msg = 'Pesanan berhasil dibatalkan.';
        if ($booking->payment_type === 'dp' && $booking->amount_paid > 0) {
            $msg .= ' Silakan hubungi admin untuk proses pengembalian dana (Refund).';
        }

        return back()->with('success', $msg);
    }

    /**
     * API Endpoint untuk mendapatkan slot waktu yang tersedia
     */
    public function getAvailableSlots(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $date = $request->query('date');
        $courtId = $request->query('court_id'); // Allow fetching specific court availability
        
        // Handle "undefined" string from JS or null values
        if ($courtId === 'undefined' || empty($courtId)) {
            $courtId = null;
        }

        $venue = Venue::with('courts')->findOrFail($id);

        if ($courtId) {
            $court = $venue->courts->where('id', $courtId)->first();
        } else {
            // Default to first court if none selected
            $court = $venue->courts->first(); 
        }

        if (!$court) {
             return response()->json([
                'available_slots' => [],
                'has_custom_pricing' => false,
                'message' => 'No court found for this venue.',
                'courts' => $venue->courts,
                'selected_court' => null
            ]);
        }

        // Ambil semua booking yang sudah ada pada tanggal, venue, & COURT tersebut
        $existingBookings = Booking::where('venue_id', $id)
            ->where('court_id', $court->id)
            ->where('booking_date', $date)
            ->whereIn('status', ['paid', 'confirmed', 'pending'])
            ->get();

        $bookedSlots = [];
        foreach ($existingBookings as $booking) {
            // Ensure time_slots is an array (safeguard against nulls/errors)
            $slots = is_array($booking->time_slots) ? $booking->time_slots : [];
            $bookedSlots = array_merge($bookedSlots, $slots);
        }

        // Cek apakah court memiliki konfigurasi time slot
        $timeSlotConfigs = \App\Models\TimeSlotConfig::where('court_id', $court->id)
            ->where('is_active', true)
            ->orderBy('start_time')
            ->get();

        if ($timeSlotConfigs->isNotEmpty()) {
            // Urutkan berdasarkan jam buka venue (slot sebelum jam buka pindah ke belakang)
            $openHour = $venue->operation_start_time 
                ? (int) substr($venue->operation_start_time, 0, 2) 
                : 7;

            $sorted = $timeSlotConfigs->sortBy(function($config) use ($openHour) {
                $hour = (int) date('H', strtotime($config->start_time));
                return $hour < $openHour ? $hour + 24 : $hour;
            });

            $slots = [];
            foreach ($sorted as $config) {
                $slotTime = date('H:i', strtotime($config->start_time));
                $isBooked = in_array($slotTime, $bookedSlots);
                $slots[] = [
                    'time' => $slotTime,
                    'price' => $config->price,
                    'status' => $isBooked ? 'booked' : 'available',
                ];
            }

            return response()->json([
                'available_slots' => $slots,
                'has_custom_pricing' => true,
                'courts' => $venue->courts,
                'selected_court' => $court->id,
            ]);
        }

        // Fallback (Rare case if configs not generated)
        return response()->json([
            'available_slots' => [],
            'has_custom_pricing' => false,
            'courts' => $venue->courts,
            'selected_court' => $court->id,
        ]);
    }
}
