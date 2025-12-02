<?php

namespace App\Modules\Home\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DoctorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => DoctorResource::collection($this->collection),
        ];
    }
}
