<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // === TABEL USERS (Pengguna) ===
        DB::statement("ALTER TABLE `users` COMMENT = 'Tabel Pengguna'");
        DB::statement("ALTER TABLE `users` MODIFY `name` VARCHAR(255) NOT NULL COMMENT 'Nama Lengkap'");
        DB::statement("ALTER TABLE `users` MODIFY `email` VARCHAR(255) NOT NULL COMMENT 'Alamat Email'");
        DB::statement("ALTER TABLE `users` MODIFY `password` VARCHAR(255) NOT NULL COMMENT 'Kata Sandi'");
        DB::statement("ALTER TABLE `users` MODIFY `phone` VARCHAR(255) NULL COMMENT 'Nomor HP'");
        DB::statement("ALTER TABLE `users` MODIFY `role` VARCHAR(255) NOT NULL DEFAULT 'user' COMMENT 'Peran (admin/user)'");

        // === TABEL VENUES (Lapangan) ===
        DB::statement("ALTER TABLE `venues` COMMENT = 'Tabel Lapangan / GOR'");
        DB::statement("ALTER TABLE `venues` MODIFY `name` VARCHAR(255) NOT NULL COMMENT 'Nama GOR'");
        DB::statement("ALTER TABLE `venues` MODIFY `address` TEXT NOT NULL COMMENT 'Alamat'");
        DB::statement("ALTER TABLE `venues` MODIFY `contact_phone` VARCHAR(255) NULL COMMENT 'Nomor Kontak'");
        DB::statement("ALTER TABLE `venues` MODIFY `price` INT NOT NULL COMMENT 'Harga Per Jam'");
        DB::statement("ALTER TABLE `venues` MODIFY `type` VARCHAR(255) NULL COMMENT 'Jenis Rumput'");
        DB::statement("ALTER TABLE `venues` MODIFY `image` VARCHAR(255) NULL COMMENT 'Foto Lapangan'");
        DB::statement("ALTER TABLE `venues` MODIFY `facilities` JSON NULL COMMENT 'Fasilitas (Parkir, WC, dll)'");
        DB::statement("ALTER TABLE `venues` MODIFY `operation_start_time` TIME NULL COMMENT 'Jam Buka'");
        DB::statement("ALTER TABLE `venues` MODIFY `operation_end_time` TIME NULL COMMENT 'Jam Tutup'");

        // === TABEL COURTS (Lapangan per GOR) ===
        DB::statement("ALTER TABLE `courts` COMMENT = 'Tabel Detail Lapangan'");

        // === TABEL BOOKINGS (Pemesanan) ===
        DB::statement("ALTER TABLE `bookings` COMMENT = 'Tabel Pemesanan'");
        DB::statement("ALTER TABLE `bookings` MODIFY `customer_name` VARCHAR(255) NOT NULL COMMENT 'Nama Pemesan'");
        DB::statement("ALTER TABLE `bookings` MODIFY `customer_phone` VARCHAR(255) NOT NULL COMMENT 'No HP Pemesan'");
        DB::statement("ALTER TABLE `bookings` MODIFY `booking_date` DATE NOT NULL COMMENT 'Tanggal Main'");
        DB::statement("ALTER TABLE `bookings` MODIFY `time_slots` JSON NOT NULL COMMENT 'Jam Sewa'");
        DB::statement("ALTER TABLE `bookings` MODIFY `total_price` DECIMAL(12,2) NOT NULL COMMENT 'Total Harga'");
        DB::statement("ALTER TABLE `bookings` MODIFY `status` VARCHAR(255) NOT NULL DEFAULT 'pending' COMMENT 'Status (pending/dp/paid/cancelled)'");
        DB::statement("ALTER TABLE `bookings` MODIFY `payment_type` VARCHAR(255) NOT NULL DEFAULT 'full' COMMENT 'Tipe Bayar (full/dp)'");
        DB::statement("ALTER TABLE `bookings` MODIFY `order_id` VARCHAR(255) NULL COMMENT 'ID Pesanan'");

        // === TABEL PAYMENT_METHODS (Metode Pembayaran) ===
        DB::statement("ALTER TABLE `payment_methods` COMMENT = 'Tabel Metode Pembayaran'");
        DB::statement("ALTER TABLE `payment_methods` MODIFY `name` VARCHAR(255) NOT NULL COMMENT 'Nama Metode'");
        DB::statement("ALTER TABLE `payment_methods` MODIFY `account_number` VARCHAR(255) NULL COMMENT 'Nomor Rekening'");
        DB::statement("ALTER TABLE `payment_methods` MODIFY `account_name` VARCHAR(255) NULL COMMENT 'Nama Pemilik Rekening'");
        DB::statement("ALTER TABLE `payment_methods` MODIFY `instructions` TEXT NULL COMMENT 'Instruksi Pembayaran'");
        DB::statement("ALTER TABLE `payment_methods` MODIFY `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Aktif (Ya/Tidak)'");

        // === TABEL TRANSACTIONS (Transaksi) ===
        DB::statement("ALTER TABLE `transactions` COMMENT = 'Tabel Transaksi Pembayaran'");
    }

    public function down(): void
    {
        // Komentar tidak perlu di-rollback
    }
};
