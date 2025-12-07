<?php

namespace App\Modules\Booking\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Modules\Booking\Requests\BookAppointmentRequest;
use App\Modules\Booking\Requests\RescheduleAppointmentRequest;
use App\Modules\Booking\Resources\AppointmentResource;
use App\Modules\Booking\Resources\MyAppointmentResource;
use App\Modules\Booking\Services\AppointmentService;
use App\Enums\AppointmentStatus;

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
        $appointment = Appointment::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$appointment) {
            return apiResponse(false, 'Appointment not found.', null, 404);
        }

        if ($appointment->isBefore24Hours()) {
            return apiResponse(
                false,
                'Cancellation must be made at least 24 hours in advance.',
                null,
                422
            );
        }

        $appointment->update([
            'status' => AppointmentStatus::Cancelled->value,
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

        // Merge old values with new ones
        $newDate = $request->appointment_date ?? $appointment->appointment_date;
        $newTime = $request->appointment_time ?? $appointment->appointment_time;

        // Check if the new slot is available (excluding this appointment itself)
        $slotTaken = Appointment::where('doctor_id', $appointment->doctor_id)
            ->where('appointment_date', $newDate)
            ->where('appointment_time', $newTime)
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($slotTaken) {
            return apiResponse(
                false,
                'This time slot is already booked.',
                null,
                422
            );
        }

        // Prepare update data
        $updateData = [
            'appointment_date' => $newDate,
            'appointment_time' => $newTime,
        ];

        // If previously cancelled, reactivate the appointment
        if ($appointment->status === AppointmentStatus::Cancelled->value) {
            $updateData['status'] = AppointmentStatus::PendingPayment->value;
        }

        $appointment->update($updateData);

        return apiResponse(
            true,
            'Appointment rescheduled successfully',
            new AppointmentResource($appointment->load(['doctor', 'user']))
        );
    }
}
