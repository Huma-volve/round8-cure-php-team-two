<?php

namespace App\Modules\Booking\Requests;

use App\Models\Appointment;
use App\Models\DoctorTime;
use Illuminate\Foundation\Http\FormRequest;

class BookAppointmentRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:users,id',
            'date'      => 'required|date|after_or_equal:today',
            'time'      => [
                'required',
                'date_format:H:i',
                function($attribute, $value, $fail) {
                    $doctorId = $this->input('doctor_id');
                    $date = $this->input('date');

                    if ($doctorId && $date) {
                        // التحقق إذا الوقت محجوز
                        $exists = Appointment::where('doctor_id', $doctorId)
                            ->where('appointment_date', $date)
                            ->where('appointment_time', $value)
                            ->exists();
                        if ($exists) $fail("This time slot is already booked for the doctor.");

                        // التحقق من ساعات عمل الدكتور
                        $available = DoctorTime::where('doctor_id', $doctorId)
                            ->where('date', $date)
                            ->whereTime('start_time', '<=', $value)
                            ->whereTime('end_time', '>=', $value)
                            ->exists();
                        if (!$available) $fail("This time is outside the doctor's working hours.");
                    }
                }
            ],
            'payment_id'=> 'nullable|exists:payments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Doctor is required.',
            'doctor_id.exists'   => 'Selected doctor does not exist.',
            'date.required'      => 'Appointment date is required.',
            'date.after_or_equal'=> 'Appointment date cannot be in the past.',
            'time.required'      => 'Appointment time is required.',
            'time.date_format'   => 'Time must be in HH:MM format.',
        ];
    }
}
