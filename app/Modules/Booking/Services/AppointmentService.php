<?php

namespace App\Modules\Booking\Services;

use App\Modules\Booking\Repositories\AppointmentRepository;

class AppointmentService
{
    public function __construct(protected AppointmentRepository $repo) {}

    public function book(array $data)
    {
        // For testing: use a default user_id if not provided
        $userId = $data['user_id'] ?? 1; // make sure user with ID 1 exists


        return $this->repo->create([
            'doctor_id'       => $data['doctor_id'],
            //'user_id'         => auth()->id(),
            'user_id'         => $userId,
            'appointment_date'=> $data['date'],
            'appointment_time'=> $data['time'],
            'payment_id'      => $data['payment_id'] ?? null,
            'status'          => $data['status'] ?? 'pending',
            'price'           => $data['price'] ?? 0,
        ]);
    }
}
