<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatus;

class Appointment extends Model
{
    protected $fillable = [
        'comment',
        'rating',
        'doctor_id',
        'user_id',
        'appointment_date',
        'appointment_time',
        'payment_id',
        'status',
        'price'
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
    ];

    public function review() { return $this->hasOne(Review::class); }
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
    public function patient() { return $this->belongsTo(User::class, 'user_id'); }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
