<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus pemesanan yang jadwal mainnya sudah selesai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        $currentTime = now()->format('H:i');

        // 1. Hapus booking dari hari-hari sebelumnya
        $deletedOld = \App\Models\Booking::where('booking_date', '<', $today)->delete();

        // 2. Hapus booking hari ini yang jam mainnya sudah lewat
        $todayBookings = \App\Models\Booking::where('booking_date', $today)->get();
        $deletedToday = 0;

        foreach ($todayBookings as $booking) {
            $slots = $booking->time_slots;
            if (is_array($slots) && !empty($slots)) {
                // Ambil slot terakhir, misal ["10:00", "11:00"] -> ambil "11:00"
                $lastSlot = end($slots); 
                
                // Estimasi waktu selesai (asumsi 1 jam per slot)
                // Jika "11:00", maka selesai "12:00"
                $hour = (int) substr($lastSlot, 0, 2);
                $endTime = sprintf('%02d:00', $hour + 1);

                // Jika waktu sekarang sudah melewati waktu selesai
                if ($currentTime >= $endTime) {
                    $booking->delete();
                    $deletedToday++;
                }
            }
        }

        $total = $deletedOld + $deletedToday;
        $this->info("Berhasil menghapus {$total} pemesanan kadaluarsa ({$deletedOld} hari lalu, {$deletedToday} hari ini).");
    }
}
