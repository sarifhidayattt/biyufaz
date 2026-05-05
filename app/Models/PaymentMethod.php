<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'metode_pembayaran';

    protected $fillable = [
        'name',
        'account_number',
        'account_name',
        'instructions',
        'is_active',
        'logo',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
