<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $fillable = [
        "comment",
        "rating",
        "doctor_id",
        "appointment_id",
        "user_id",
        "appointment_date",
        "appointment_time",
        "payment_id",
        "status",
        "price"

    ];
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
