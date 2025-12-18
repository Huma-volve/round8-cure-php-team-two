<?php

namespace App\Modules\Booking\Services;

use App\Models\Doctor;
use App\Models\DoctorTime;
use App\Modules\Booking\Repositories\AppointmentRepository;
use App\Enums\AppointmentStatus;
use Illuminate\Support\Facades\DB;
use Exception;

class AppointmentService
{
    public function __construct(protected AppointmentRepository $repo) {}

    public function book(array $data)
    {
        return DB::transaction(function () use ($data) {

            $doctor = Doctor::findOrFail($data['doctor_id']);

            // نتأكد إن المعاد لسه متاح
            $slot = DoctorTime::where('doctor_id', $data['doctor_id'])
                ->where('date', $data['date'])
                ->where('start_time', $data['time'])
                ->first();

            if (! $slot) {
                throw new Exception('This time is no longer available.');
            }

            $appointment = $this->repo->create([
                'doctor_id'        => $data['doctor_id'],
                'user_id'          => auth()->id(),
                'appointment_date' => $data['date'],
                'appointment_time' => $data['time'],
                'status'           => $data['status'] ?? AppointmentStatus::PendingPayment->value,
                'price'            => $doctor->price,
            ]);

            $slot->delete();

            return $appointment;
        });
    }
}
