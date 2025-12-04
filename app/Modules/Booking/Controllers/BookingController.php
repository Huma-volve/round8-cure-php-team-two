<?php

namespace App\Modules\Booking\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Booking\Requests\BookAppointmentRequest;
use App\Modules\Booking\Resources\AppointmentResource;
use App\Modules\Booking\Services\AppointmentService;

class BookingController extends Controller
{
    public function __construct(protected AppointmentService $service) {}

    public function book(BookAppointmentRequest $request)
    {
        //$appointment = $this->service->book($request->validated());


        // For testing only: assign a user_id manually
        $data = $request->validated();
        $data['user_id'] = 1; // Replace with an existing user ID in your DB
        $data['status'] = 'pending_payment';

        $appointment = $this->service->book($data);
        return apiResponse(
            true,
            'Appointment booked successfully',
            new AppointmentResource($appointment),
            201
        );
    }

}
