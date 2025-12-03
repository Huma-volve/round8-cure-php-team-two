<?php

namespace App\Modules\Favorites\Repositories;

use App\Models\Doctor;
use App\Models\User;

class FavoriteRepository
{
    public function getFavorites(User $user)
    {
        return $user->favoriteDoctors()
            ->select(
                'doctors.id',
                'doctors.name',
                'doctors.specialty_id',
                'doctors.hospital_name',
                'doctors.price',
                'doctors.exp_years',
                'doctors.image'
            )
            ->get();
    }

    public function isFavorite(User $user, Doctor $doctor)
    {
        return $user->favoriteDoctors()
            ->where('doctor_id', $doctor->id)
            ->exists();
    }

    public function add(User $user, Doctor $doctor)
    {
        $user->favoriteDoctors()->attach($doctor->id);
    }

    public function remove(User $user, Doctor $doctor)
    {
        $user->favoriteDoctors()->detach($doctor->id);
    }
}
