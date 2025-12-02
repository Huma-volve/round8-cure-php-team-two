<?php

namespace App\Modules\Home\Repositories;

use App\Models\Doctor;
use App\Models\Specialty;

class HomeRepository
{

    public function getAll()
    {
        return Specialty::select('id', 'name', 'icon')->get();
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
                ->having('distance', '<=', 10)
                ->orderBy('distance');
        }

        return $query->paginate($perPage);
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
