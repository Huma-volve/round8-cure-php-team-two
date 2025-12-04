<?php

namespace App\Modules\Booking\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'doctor_id'        => $this->doctor_id,
            'user_id'          => $this->user_id,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'payment_id'       => $this->payment_id,
            'price'            => $this->price,
            'status'           => $this->status,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }
}
