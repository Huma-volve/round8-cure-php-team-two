<?php

namespace App\Http\Resources\Chat\Room;

use App\Http\Resources\Chat\Message\MessageResource;
use App\Http\Resources\Doctor\DoctorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            "room_id" => $this->id,
            "user_id" => $this->user_id,
            "doctor_id" => $this->doctor_id,
            "doctor" => DoctorResource::make($this->whenLoaded('doctor')),
            "messages" => MessageResource::collection($this->whenLoaded('messages')),
            'last_message_time' => $this->last_message_at->diffForHumans() ?? 'this is a new chat room with no messages yet.',

        ];


        return $data;
    }
}
