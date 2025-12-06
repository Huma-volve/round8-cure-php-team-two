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

    public function review() { return $this->hasOne(Review::class); }
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
    public function patient() { return $this->belongsTo(User::class, 'user_id'); }
    public function payment() { return $this->belongsTo(Payment::class); }

    public function getStatusAttribute($value): AppointmentStatus
    {
        return AppointmentStatus::from($value);
    }

    public function setStatusAttribute(AppointmentStatus|string $status): void
    {
        $this->attributes['status'] = $status instanceof AppointmentStatus ? $status->value : $status;
    }
}
