<?php

namespace App\Modules\Booking\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'doctor_id'        => $this->doctor_id,
            'user_id'          => $this->user_id,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'payment_id'       => $this->payment_id,
            'price'            => $this->price,
            'status'           => $this->status->value ?? $this->status, // يدعم enum
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
            'doctor'           => $this->whenLoaded('doctor'), // لو تم eager load
            'patient'          => $this->whenLoaded('patient'), // لو تم eager load
        ];
    }
}
