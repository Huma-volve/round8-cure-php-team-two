<?php

namespace App\Modules\Booking\Repositories;

use App\Models\Appointment;

class AppointmentRepository
{
    public function create(array $data)
    {
        return Appointment::create($data);
    }
}
