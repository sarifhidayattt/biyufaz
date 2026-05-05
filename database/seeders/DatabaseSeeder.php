<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil VenueSeeder agar data lapangan otomatis diisi
        $this->call([
            VenueSeeder::class,
        ]);
    }
}