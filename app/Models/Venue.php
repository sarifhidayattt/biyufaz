<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'lapangan';

    protected $fillable = [
        'name',
        'address',
        'contact_phone',
        'price',
        'image',
        'type',
        'facilities',
        'operation_start_time',
        'operation_end_time',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function timeSlotConfigs()
    {
        return $this->hasMany(TimeSlotConfig::class);
    }

    public function courts()
    {
        return $this->hasMany(Court::class);
    }
}