<?php

namespace App\Modules\Home\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'specialty'            => new SpecialtyResource($this->whenLoaded('specialty')),
            'hospital_name'        => $this->hospital_name ?? null,
            'location'             => $this->location,
            'bio'                  => $this->bio,
            'years_of_experience'  => $this->exp_years,
            'rating'               => round($this->average_rating ?? 0, 1),
            'total_reviews'        => $this->reviews->count(),
            'total_patients'       => $this->appointments->pluck('user_id')->unique()->count(),
            'consultation_fee'     => number_format($this->price, 2),
            'phone'                => $this->phone ?? null,
            'email'                => $this->email ?? null,
            'image' => $this->image
                ? (filter_var($this->image, FILTER_VALIDATE_URL)
                    ? $this->image
                    : asset($this->image))
                : asset('assets/admin/img/avatars/1.png'),
            'is_favorite' => auth('sanctum')->check()
                ? \DB::table('favorites')
                    ->where('doctor_id', $this->id)
                    ->where('user_id', auth('sanctum')->id())
                    ->exists()
                : false,

            'times' => TimeResource::collection($this->whenLoaded('times')),

            'reviews' => $this->reviews
                ->sortByDesc('created_at')
                ->take(5)
                ->map(function ($review) {
                    return [
                        'patient_name' => $review->user->name ?? 'Anonymous',
                        'rating'       => $review->rating,
                        'comment'      => $review->comment,
                        'time_ago'     => $review->created_at->diffForHumans(),
                    ];
                }),
        ];
    }
}
