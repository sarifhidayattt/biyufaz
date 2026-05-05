<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'QRIS (Semua Pembayaran)',
                'account_number' => 'Gunakan QRIS untuk membayar via M-Banking / E-Wallet',
                'account_name' => 'Biyufaz Futsal',
                'instructions' => 'Scan kode QR yang muncul (atau nomor di atas) menggunakan aplikasi DANA, OVO, GoPay, ShopeePay, atau M-Banking Anda.',
                'logo' => 'qris',
                'is_active' => true,
            ],
            [
                'name' => 'Bank BCA',
                'account_number' => '1234567890',
                'account_name' => 'PT Biyufaz Arena',
                'instructions' => 'Transfer tepat sesuai nominal tagihan hingga 3 digit terakhir. Simpan bukti transfer Anda.',
                'logo' => 'bca',
                'is_active' => true,
            ],
            [
                'name' => 'Bank BNI',
                'account_number' => '0987654321',
                'account_name' => 'PT Biyufaz Arena',
                'instructions' => 'Transfer tepat sesuai nominal tagihan hingga 3 digit terakhir. Simpan bukti transfer Anda.',
                'logo' => 'bni',
                'is_active' => true,
            ],
            [
                'name' => 'Bank Mandiri',
                'account_number' => '112233445566',
                'account_name' => 'PT Biyufaz Arena',
                'instructions' => 'Transfer tepat sesuai nominal tagihan hingga 3 digit terakhir. Simpan bukti transfer Anda.',
                'logo' => 'mandiri',
                'is_active' => true,
            ],
            [
                'name' => 'Bank BRI',
                'account_number' => '998877665544',
                'account_name' => 'PT Biyufaz Arena',
                'instructions' => 'Transfer tepat sesuai nominal tagihan hingga 3 digit terakhir. Simpan bukti transfer Anda.',
                'logo' => 'bri',
                'is_active' => true,
            ],
            [
                'name' => 'Bank BSI',
                'account_number' => '5566778899',
                'account_name' => 'PT Biyufaz Arena',
                'instructions' => 'Transfer tepat sesuai nominal tagihan hingga 3 digit terakhir. Simpan bukti transfer Anda.',
                'logo' => 'bsi',
                'is_active' => true,
            ],
            [
                'name' => 'DANA',
                'account_number' => '081234567890',
                'account_name' => 'Biyufaz Futsal',
                'instructions' => 'Kirim uang ke nomor DANA di atas atau gunakan opsi Transfer QR.',
                'logo' => 'dana',
                'is_active' => true,
            ],
            [
                'name' => 'OVO',
                'account_number' => '081234567890',
                'account_name' => 'Biyufaz Futsal',
                'instructions' => 'Kirim uang ke nomor OVO di atas. Pastikan nama penerima sesuai.',
                'logo' => 'ovo',
                'is_active' => true,
            ],
            [
                'name' => 'GoPay',
                'account_number' => '081234567890',
                'account_name' => 'Biyufaz Futsal',
                'instructions' => 'Kirim uang ke nomor GoPay di atas. Pastikan nama penerima sesuai.',
                'logo' => 'gopay',
                'is_active' => true,
            ],
            [
                'name' => 'ShopeePay',
                'account_number' => '081234567890',
                'account_name' => 'Biyufaz Futsal',
                'instructions' => 'Kirim uang ke nomor ShopeePay di atas. Pastikan nama penerima sesuai.',
                'logo' => 'shopeepay',
                'is_active' => true,
            ],
            [
                'name' => 'LinkAja',
                'account_number' => '081234567890',
                'account_name' => 'Biyufaz Futsal',
                'instructions' => 'Kirim uang ke nomor LinkAja di atas. Pastikan nama penerima sesuai.',
                'logo' => 'linkaja',
                'is_active' => true,
            ],
        ];

        // Hapus data lama agar tidak duplikat jika dijalankan ulang (opsional)
        PaymentMethod::truncate();

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
