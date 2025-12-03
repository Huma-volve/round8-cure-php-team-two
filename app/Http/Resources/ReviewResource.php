<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'doctor_id' => $this->doctor_id,
            'rating'    => $this->rating,
            'comment'   => $this->comment,
            'user'=>[
                "name"=> "Ms. Annabel Crona MD",
                "email"=> "akub@example.com",
                "phone"=> "+1 (210) 902-5433",
                "gender"=> "male",
            ],
            // 'user'      =>  $this->whenLoaded('user'),
            'created_at'=> $this->created_at->format('Y-m-d'),
        ];
    }
}
