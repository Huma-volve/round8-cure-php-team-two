<?php

namespace App\Modules\Search\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'specialty' => $this->specialty?->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
        ];
    }
}
