<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Nama tabel di database sesuai migrasi Anda.
     * Karena default Laravel adalah 'users', baris ini sebenarnya opsional.
     */
    protected $table = 'pengguna';

    /**
     * Kolom yang boleh diisi (Mass Assignment).
     * Nama-nama ini disesuaikan dengan kolom di file migrasi Anda.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',    // Tambahkan di migrasi jika ingin digunakan
        'role',     // Tambahkan di migrasi jika ingin digunakan
        'otp',      // Tambahkan di migrasi jika ingin digunakan
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Gunakan casting bawaan Laravel.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}