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

    // Relationship to patient/user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Check if appointment is within 24 hours
    public function isBefore24Hours(): bool
    {
        return now()->diffInHours($this->appointment_date . ' ' . $this->appointment_time, false) < 24;
    }
}
