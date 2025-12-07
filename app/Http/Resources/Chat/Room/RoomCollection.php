<?php

namespace App\Http\Resources\Chat\Room;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoomCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rooms' => RoomResource::collection($this->collection),
            'rooms_count' => $this->collection->count(),
        ];
    }
}
