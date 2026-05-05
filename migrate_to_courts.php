<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Venue;
use App\Models\Court;
use App\Models\TimeSlotConfig;
use App\Models\Booking;

// Retrieve all venues
$venues = Venue::all();

foreach ($venues as $venue) {
    // Check if court already exists
    $court = Court::where('venue_id', $venue->id)->first();
    
    if (!$court) {
        $court = Court::create([
            'venue_id' => $venue->id,
            'name' => 'Lapangan Utama',
            'type' => $venue->type,
            'price' => $venue->price,
        ]);
        echo "Created Court 'Lapangan Utama' for Venue ID: {$venue->id}\n";
    }

    // Update time slot configs with this court ID
    TimeSlotConfig::where('venue_id', $venue->id)
        ->whereNull('court_id')
        ->update(['court_id' => $court->id]);
        
    // Update bookings
    Booking::where('venue_id', $venue->id)
        ->whereNull('court_id')
        ->update(['court_id' => $court->id]);
        
    echo "Updated TimeSlots and Bookings for Venue ID: {$venue->id} to Court ID: {$court->id}\n";
}
echo "Migration Complete!\n";
