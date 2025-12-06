<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'price',
        'status',
        'payment_method',
        'payment_details',
        'stripe_payment_intent_id',
        'appointment_id',
        'user_id',
    ];

    protected $casts = [
        'payment_details' => 'array',
    ];

    // العلاقات
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
