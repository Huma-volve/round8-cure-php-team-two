<?php

namespace App\Modules\Booking\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RescheduleAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.required' => 'Appointment date is required.',
            'appointment_time.required' => 'Appointment time is required.',
        ];
    }
}
