<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;
use Illuminate\Support\Facades\Schema; // <--- This is required

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Disable foreign key checks temporarily
        Schema::disableForeignKeyConstraints();

        // 2. Truncate the table
        Venue::truncate();

        // 3. Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // 4. Fill with new data
        Venue::create([
            'id' => 1,
            'name' => 'Futsal Attelo',
            'address' => 'Jl. Cingised No.38, Bandung',
            'price' => 120000,
            'image' => 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'type' => 'Synthetic Grass'
        ]);

        Venue::create([
            'id' => 2,
            'name' => 'Galaxy Sports Center',
            'address' => 'Jl. Galaxy Raya, Bandung',
            'price' => 120000,
            'image' => 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'type' => 'Synthetic'
        ]);

        Venue::create([
            'id' => 3,
            'name' => 'Metro Futsal Point',
            'address' => 'Jl. Metro Indah, Surabaya',
            'price' => 100000,
            'image' => 'https://images.unsplash.com/photo-1518605348399-4c2225f65239?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'type' => 'Vinyl / Indoor'
        ]);
    }
}