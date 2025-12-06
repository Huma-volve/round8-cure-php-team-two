<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'price',
        'status',
        'payment_details',
        'stripe_payment_intent_id',
        'user_id',
        'appointment_id',
        'payment_method'
    ];

    protected $casts = [
        'payment_details' => 'array',
    ];
}
