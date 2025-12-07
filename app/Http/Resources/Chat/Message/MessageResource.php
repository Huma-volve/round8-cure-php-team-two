<?php

namespace App\Http\Resources\Chat\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chat_id' => $this->chat_id,
            'message_id' => $this->id,
            'message_type' => $this->type,
            'message_sender' => $this->sender()->select('id' , 'name')->first(),
            'message_content' => $this->type !== 'text' ? asset($this->content) : $this->content,
            'message_seen' => $this->seen,
            'message_created_at' => $this->created_at,
        ];
    }
}
