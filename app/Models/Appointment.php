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
        "user_id"
    ];
    public function review()
    {
        return $this->hasOne(Review::class);
    }

}
