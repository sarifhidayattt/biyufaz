<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rename semua tabel ke Bahasa Indonesia
     * CATATAN: Tabel sistem Laravel (sessions, migrations, cache, jobs, dll) TIDAK diubah
     */
    public function up(): void
    {
        // users → pengguna
        Schema::rename('pengguna', 'pengguna');

        // venues → lapangan
        Schema::rename('lapangan', 'lapangan');

        // courts → detail_lapangan
        Schema::rename('detail_lapangan', 'detail_lapangan');

        // bookings → pemesanan
        Schema::rename('pemesanan', 'pemesanan');

        // time_slot_configs → slot_waktu
        Schema::rename('slot_waktu', 'slot_waktu');

        // payment_methods → metode_pembayaran
        Schema::rename('metode_pembayaran', 'metode_pembayaran');

        // transactions → transaksi
        Schema::rename('transaksi', 'transaksi');
    }

    public function down(): void
    {
        Schema::rename('pengguna', 'pengguna');
        Schema::rename('lapangan', 'lapangan');
        Schema::rename('detail_lapangan', 'detail_lapangan');
        Schema::rename('pemesanan', 'pemesanan');
        Schema::rename('slot_waktu', 'slot_waktu');
        Schema::rename('metode_pembayaran', 'metode_pembayaran');
        Schema::rename('transaksi', 'transaksi');
    }
};
