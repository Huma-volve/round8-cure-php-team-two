<?php

namespace App\Modules\Search\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'specialty'     => $this->specialty?->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'avatar'        => $this->avatar,

            'rating'        => round($this->average_rating ?? 0, 1),
            'price'         => number_format($this->price, 2),
            'hospital_name' => $this->hospital_name,

            'location' => $this->location,

            'times' => $this->times->map(function ($time) {
                return [
                    'date'       => $time->date,
                    'start_time' => $time->start_time,
                    'end_time'   => $time->end_time,
                ];
            }),

        ];
    }
}
