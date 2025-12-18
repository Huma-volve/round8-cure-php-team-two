<?php

namespace App\Modules\Booking\Controllers;

use App\Events\AppointmentBookedEvent;
use App\Events\AppointmentCanceledEvent;
use App\Events\AppointmentUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorTime;
use App\Modules\Booking\Requests\BookAppointmentRequest;
use App\Modules\Booking\Requests\RescheduleAppointmentRequest;
use App\Modules\Booking\Resources\AppointmentResource;
use App\Modules\Booking\Resources\MyAppointmentResource;
use App\Modules\Booking\Services\AppointmentService;
use App\Enums\AppointmentStatus;

class BookingController extends Controller
{
    public function __construct(protected AppointmentService $service) {}

    // حجز موعد جديد
    public function book(BookAppointmentRequest $request)
    {
        $appointment = $this->service->book($request->validated());
        event(new AppointmentBookedEvent($appointment));

        return apiResponse(
            true,
            'Appointment booked successfully',
            new AppointmentResource($appointment->load(['doctor', 'user'])),
            201
        );
    }

    // جلب جميع مواعيد المستخدم
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

    // إلغاء موعد
    public function cancel($id)
    {
        $appointment = Appointment::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$appointment) {
            return apiResponse(false, 'Appointment not found.', null, 404);
        }

        if ($appointment->status === AppointmentStatus::Cancelled->value) {
            return apiResponse(false, 'Appointment is already cancelled.', null, 422);
        }

        if (!$appointment->canCancelOrReschedule()) {
            return apiResponse(
                false,
                'Cannot cancel the appointment after the appointment time has passed.',
                null,
                422
            );
        }

        $appointment->update([
            'status' => AppointmentStatus::Cancelled->value,
        ]);

        event(new AppointmentCanceledEvent($appointment));

        return apiResponse(true, 'Appointment cancelled successfully');
    }

    // إعادة جدولة موعد
    public function reschedule(RescheduleAppointmentRequest $request, $id)
    {
        $appointment = Appointment::where('user_id', auth()->id())->findOrFail($id);

        if ($appointment->status === AppointmentStatus::Cancelled->value) {
            return apiResponse(false, 'Cannot reschedule a cancelled appointment.', null, 422);
        }

        if (!$appointment->canCancelOrReschedule()) {
            return apiResponse(
                false,
                'Cannot reschedule the appointment after the appointment time has passed.',
                null,
                422
            );
        }

        $newDate = $request->appointment_date ?? $appointment->appointment_date;
        $newTime = $request->appointment_time ?? $appointment->appointment_time;

        if ($appointment->appointment_date == $newDate &&
            $appointment->appointment_time == $newTime) {
            return apiResponse(false, 'No changes detected.', null, 422);
        }

        // التحقق من وجود أي حجز آخر لنفس الدكتور بنفس الوقت
        $existingBooking = Appointment::where('doctor_id', $appointment->doctor_id)
            ->where('appointment_date', $newDate)
            ->where('appointment_time', $newTime)
            ->where('id', '!=', $appointment->id)
            ->first();

        if ($existingBooking && $existingBooking->status !== AppointmentStatus::Cancelled->value) {
            return apiResponse(false, 'This time slot is already booked.', null, 422);
        }

        // التحقق من ساعات عمل الدكتور
        $isWithinWorkingHours = DoctorTime::where('doctor_id', $appointment->doctor_id)
            ->where('date', $newDate)
            ->whereTime('start_time', '<=', $newTime)
            ->whereTime('end_time', '>=', $newTime)
            ->exists();

        if (!$isWithinWorkingHours) {
            return apiResponse(false, "This time is outside the doctor's working hours.", null, 422);
        }

        $appointment->update([
            'appointment_date' => $newDate,
            'appointment_time' => $newTime,
        ]);

        event(new AppointmentUpdatedEvent($appointment));

        return apiResponse(
            true,
            'Appointment rescheduled successfully',
            new AppointmentResource($appointment->load(['doctor', 'user']))
        );
    }
}
