<?php

namespace App\Modules\Favorites\Services;

use App\Models\Doctor;
use App\Models\User;
use App\Modules\Favorites\Repositories\FavoriteRepository;

class FavoriteService
{
    public function __construct(
        protected FavoriteRepository $favoriteRepository
    ) {}

    public function list(User $user)
    {
        $favorites = $this->favoriteRepository->getFavorites($user);

        return $favorites->map(function ($doctor) {
            $doctor->is_favorite = true;
            return $doctor;
        });
    }

    public function toggle(User $user, Doctor $doctor)
    {
        $exists = $this->favoriteRepository->isFavorite($user, $doctor);

        if ($exists) {
            $this->favoriteRepository->remove($user, $doctor);

            return [
                'added' => false,
                'message' => 'Removed from favorites',
            ];
        }

        $this->favoriteRepository->add($user, $doctor);

        return [
            'added' => true,
            'message' => 'Added to favorites',
        ];
    }
}
