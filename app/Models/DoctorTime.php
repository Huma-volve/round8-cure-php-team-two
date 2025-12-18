<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTime extends Model
{
    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
    ];
}
