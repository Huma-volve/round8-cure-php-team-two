<?php

namespace App\Modules\Booking\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyAppointmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'doctor'        => [
                'id'      => $this->doctor->id,
                'name'    => $this->doctor->name,
                'image'   => $this->doctor->image,
                'spec'    => $this->doctor->specialization,
                'address' => $this->doctor->address,
            ],
            'date'          => $this->appointment_date,
            'time'          => $this->appointment_time,
            'status'        => $this->status->value ?? $this->status,
            'can_reschedule'=> $this->resource->canCancelOrReschedule(),
            'can_cancel'    => $this->resource->canCancelOrReschedule(),
        ];
    }
}
