<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@futsalpoint.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'), // Password admin
            'role' => 'admin', // Role Admin
            'otp_verified_at' => now(), // Langsung verifikasi
        ]);
    }
}