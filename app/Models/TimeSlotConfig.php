<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlotConfig extends Model
{
    protected $table = 'slot_waktu';

    protected $fillable = [
        'venue_id',
        'court_id',
        'start_time',
        'end_time',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function getStartTimeFormattedAttribute()
    {
        return date('H:i', strtotime($this->start_time));
    }

    public function getEndTimeFormattedAttribute()
    {
        return date('H:i', strtotime($this->end_time));
    }
}
