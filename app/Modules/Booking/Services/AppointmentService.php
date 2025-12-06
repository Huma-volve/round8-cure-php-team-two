<?php

namespace App\Modules\Booking\Services;

use App\Modules\Booking\Repositories\AppointmentRepository;
use App\Enums\AppointmentStatus;

class AppointmentService
{
    public function __construct(protected AppointmentRepository $repo) {}

    public function book(array $data)
    {
        return $this->repo->create([
            'doctor_id'        => $data['doctor_id'],
            'user_id'          => auth()->id(),
            'appointment_date' => $data['date'],
            'appointment_time' => $data['time'],
            'payment_id'       => $data['payment_id'] ?? null,
            'status'           => $data['status'] ?? AppointmentStatus::PendingPayment,
            'price'            => $data['price'] ?? 0,
        ]);
    }
}
