<?php

namespace App\Modules\Home\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialtyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'icon' => $this->icon,
        ];
    }
}
