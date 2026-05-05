<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'paid_at',
    ];

    protected $dates = ['paid_at'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
