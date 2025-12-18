<?php

namespace App\Modules\Favorites\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Home\Resources\TimeResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'specialty'      => $this->specialty?->name,
            'hospital_name'  => $this->hospital_name,
            'price'          => number_format($this->price, 2),
            'exp_years'      => $this->exp_years,
            'image'          => $this->image ? asset('storage/' . $this->image) : null,
            'rating'         => round($this->average_rating ?? 0, 1),
            'times'          => TimeResource::collection($this->times),
            'is_favorite'    => true,
        ];
    }
}
