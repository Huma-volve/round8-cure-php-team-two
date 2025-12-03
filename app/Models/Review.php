<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
     protected $fillable = [
        "comment",
        "rating",
        "doctor_id",
        "appointment_id",
        "user_id"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Each review belongs to one doctor
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Each review belongs to one appointment
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
