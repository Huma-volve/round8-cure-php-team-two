<?php

namespace App\Modules\Home\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'image'         => $this->image,
            'hospital_name' => $this->hospital_name,
            'specialty_id'  => $this->specialty_id,
            'specialty'     => new SpecialtyResource($this->whenLoaded('specialty')),
            'location'      => $this->location,
            'times'         => TimeResource::collection($this->whenLoaded('times')),
            'rating'        => round($this->average_rating ?? 0, 1),
            'distance'      => isset($this->distance) ? round($this->distance, 2) : null,
        ];
    }
}
