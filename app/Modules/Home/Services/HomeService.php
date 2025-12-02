<?php

namespace App\Modules\Home\Services;


use App\Modules\Home\Repositories\HomeRepository;

class HomeService
{
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function getPaginatedSpecialties(int $perPage = 10)
    {
        return $this->homeRepository->getAllPaginated($perPage);
    }

    public function getDoctorsNearYou(int $perPage = 5)
    {
        return $this->homeRepository->getDoctorsNearYouPaginated($perPage);
    }

    public function getDoctorDetails(int $id): array
    {
        $doctor = $this->homeRepository->findByIdWithRelations($id);

        return [
            'id' => $doctor->id,
            'name' => $doctor->name,
            'specialty' => $doctor->specialty,
            'location' => $doctor->location,
            'bio' => $doctor->bio,
            'years_of_experience' => $doctor->exp_years,
            'rating' => round($doctor->average_rating ?? 0, 1),
            'total_reviews' => $doctor->reviews()->count(),
            'total_patients' => $doctor->appointments()->distinct('user_id')->count(),
            'consultation_fee' => number_format($doctor->price, 2),
            'profile_image' => $doctor->image ? asset('storage/' . $doctor->image) : null,
            'times' => $doctor->times->map(function($time) {
                return [
                    'date' => $time->date,
                    'start_time' => $time->start_time,
                    'end_time' => $time->end_time,
                ];
            }),
            'reviews' => $doctor->reviews->sortByDesc('created_at')->take(5)->map(function($review) {
                return [
                    'patient_name' => $review->user->name ?? 'Anonymous',
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'time_ago' => $review->created_at->diffForHumans(),
                ];
            })
        ];
    }
}
