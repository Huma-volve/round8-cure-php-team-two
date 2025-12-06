<?php

namespace App\Modules\Booking\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Modules\Booking\Requests\BookAppointmentRequest;
use App\Modules\Booking\Requests\RescheduleAppointmentRequest;
use App\Modules\Booking\Resources\AppointmentResource;
use App\Modules\Booking\Resources\MyAppointmentResource;
use App\Modules\Booking\Services\AppointmentService;

class BookingController extends Controller
{
    public function __construct(protected AppointmentService $service) {}

    public function book(BookAppointmentRequest $request)
    {
        $appointment = $this->service->book($request->validated());

        return apiResponse(
            true,
            'Appointment booked successfully',
            new AppointmentResource($appointment->load(['doctor', 'user'])),
            201
        );
    }

    public function myBookings()
    {
        $appointments = Appointment::with(['doctor', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return apiResponse(
            true,
            'My bookings retrieved successfully',
            MyAppointmentResource::collection($appointments)
        );
    }

    public function cancel($id)
    {
        $appointment = Appointment::where('user_id', auth()->id())->findOrFail($id);

        if ($appointment->isBefore24Hours()) {
            return apiResponse(
                false,
                'Cancellation must be made at least 24 hours in advance.',
                null,
                422
            );
        }

        $appointment->update([
            'status' => 'cancelled'
        ]);

        return apiResponse(true, 'Appointment cancelled successfully');
    }

    public function reschedule(RescheduleAppointmentRequest $request, $id)
    {
        $appointment = Appointment::where('user_id', auth()->id())->findOrFail($id);

        if ($appointment->isBefore24Hours()) {
            return apiResponse(
                false,
                'Reschedule must be at least 24 hours before appointment.',
                null,
                422
            );
        }

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
        ]);

        return apiResponse(
            true,
            'Appointment rescheduled successfully',
            new AppointmentResource($appointment->load(['doctor', 'user']))
        );
    }
}
