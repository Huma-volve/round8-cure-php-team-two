<?php

namespace App\Modules\Home\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'date'       => $this->date,
            'start_time' => $this->start_time,
            'end_time'   => $this->end_time,
        ];
    }
}
