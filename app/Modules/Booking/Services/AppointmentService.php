<?php

namespace App\Modules\Booking\Services;

use App\Models\Doctor;
use App\Modules\Booking\Repositories\AppointmentRepository;
use App\Enums\AppointmentStatus;

class AppointmentService
{
    public function __construct(protected AppointmentRepository $repo) {}

    public function book(array $data)
    {
        $doctor = Doctor::findOrFail($data['doctor_id']);
        return $this->repo->create([
            'doctor_id'        => $data['doctor_id'],
            'user_id'          => auth()->id(),
            'appointment_date' => $data['date'],  // map date -> appointment_date
            'appointment_time' => $data['time'],  // map time -> appointment_time
            'status'           => $data['status'] ?? AppointmentStatus::PendingPayment->value,
            'price'            => $doctor->price,
        ]);

    }
}
