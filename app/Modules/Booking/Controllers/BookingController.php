<?php

namespace App\Modules\Booking\Controllers;

use App\Events\AppointmentBookedEvent;
use App\Http\Controllers\Controller;
use App\Modules\Booking\Requests\BookAppointmentRequest;
use App\Modules\Booking\Resources\AppointmentResource;
use App\Modules\Booking\Services\AppointmentService;

class BookingController extends Controller
{
    public function __construct(protected AppointmentService $service)
    {
    }

    public function book(BookAppointmentRequest $request)
    {
        $appointment = $this->service->book($request->validated());
        event(new AppointmentBookedEvent($appointment));
        return apiResponse(
            true,
            'Appointment booked successfully',
            new AppointmentResource($appointment->load(['doctor', 'patient'])),
            201
        );
    }
}
