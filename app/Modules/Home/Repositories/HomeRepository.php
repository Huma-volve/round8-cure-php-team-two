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
    public function getDoctorsNearYouPaginated($perPage = 5, $lat = null, $lng = null)
    {
        $query = Doctor::with(['specialty', 'times', 'reviews'])
            ->select('id', 'name', 'image', 'hospital_name', 'specialty_id', 'location');

        if ($lat && $lng) {
            $query->selectRaw("
            ( 6371 * acos(
                cos(radians(?)) * cos(radians(JSON_EXTRACT(location, '$.lat'))) *
                cos(radians(JSON_EXTRACT(location, '$.lng')) - radians(?)) +
                sin(radians(?)) * sin(radians(JSON_EXTRACT(location, '$.lat')))
            )) AS distance
        ", [$lat, $lng, $lat])
                ->having('distance', '<=', 10) // مثلاً ضمن 10 كم
                ->orderBy('distance');
        }

        return $query->paginate($perPage)->through(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'image' => $doctor->image,
                'hospital_name' => $doctor->hospital_name,
                'specialty_id' => $doctor->specialty_id,
                'specialty' => $doctor->specialty,
                'location' => $doctor->location,
                'times' => $doctor->times,
                'rating' => round($doctor->average_rating ?? 0, 1),
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
