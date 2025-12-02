<?php

namespace App\Modules\Home\Repositories;

use App\Models\Doctor;
use App\Models\Specialty;

class HomeRepository
{

    public function getAllPaginated(int $perPage = 10)
    {
        return Specialty::select('id', 'name', 'icon')->paginate($perPage);
    }
    public function getDoctorsNearYouPaginated(int $perPage = 5)
    {
        return Doctor::with(['specialty', 'times', 'reviews'])
        ->select('id', 'name', 'image', 'hospital_name', 'specialty_id')
            ->paginate($perPage)
            ->through(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'image' => $doctor->image,
                    'hospital_name' => $doctor->hospital_name,
                    'specialty_id' => $doctor->specialty_id,
                    'specialty' => $doctor->specialty,
                    'times' => $doctor->times,
                    'rating' => round($doctor->average_rating, 1), // average from reviews
                ];
            });
    }

    //doctor details
    public function findByIdWithRelations(int $id): Doctor
    {
        return Doctor::with([
            'specialty',
            'times',
            'reviews.user',
            'appointments.user'
        ])->findOrFail($id);
    }

}
