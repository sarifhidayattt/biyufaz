<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'venue_id',
        'court_id',
        'court_type',
        'customer_name',
        'customer_phone',
        'booking_date',
        'time_slots',
        'total_price',
        'order_id',
        'status',
        'payment_type',
        'amount_paid'
    ];

    protected $casts = [
        'time_slots' => 'array',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function court()
    {
        return $this->belongsTo(Court::class, 'court_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}