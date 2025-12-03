<?php

namespace App\Modules\Favorites\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'specialty_id'   => $this->specialty_id,
            'hospital_name'  => $this->hospital_name,
            'price'          => $this->price,
            'exp_years'      => $this->exp_years,
            'image'          => $this->image,
            'is_favorite'    => true,
        ];
    }
}
