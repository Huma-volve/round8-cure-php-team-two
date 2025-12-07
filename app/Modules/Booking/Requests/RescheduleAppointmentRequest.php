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
            'appointment_date' => ['sometimes', 'nullable', 'date'],
            'appointment_time' => ['sometimes', 'nullable', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.date'       => 'Appointment date must be a valid date.',
            'appointment_time.date_format'=> 'Appointment time must be in HH:MM format.',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->filled('appointment_date') && !$this->filled('appointment_time')) {
                $validator->errors()->add(
                    'general',
                    'You must provide at least a date or a time to reschedule.'
                );
            }
        });
    }
}
