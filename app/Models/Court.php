<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $table = 'detail_lapangan';

    protected $fillable = [
        'venue_id',
        'name',
        'type',
        'price',
        'image',
        'is_active',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function timeSlotConfigs()
    {
        return $this->hasMany(TimeSlotConfig::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
