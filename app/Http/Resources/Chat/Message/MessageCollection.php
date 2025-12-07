<?php

namespace App\Http\Resources\Chat\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'messages' => MessageResource::collection($this->collection),
            'messages_count' => $this->collection->count(),
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'current_page' => $this->currentPage(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage(),
                'total' => $this->total(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'path' => $this->path(),
                'next_page' => $this->nextPageUrl() ? $this->currentPage() + 1 : null,
                'prev_page' => $this->previousPageUrl() ? $this->currentPage() - 1 : null,
            ]
        ];
    }
}

