<?php

namespace App\Modules\Booking\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Return true if all authenticated users can book appointments
        //return auth()->check();
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:users,id',
            'date'      => 'required|date|after_or_equal:today',
            'time'      => 'required|date_format:H:i',
            'payment_id'=> 'nullable|exists:payments,id',
            'status'    => 'nullable|in:pending,confirmed,cancelled',
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
