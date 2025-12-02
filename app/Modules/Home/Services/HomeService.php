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

    public function getPaginatedSpecialties()
    {
        return $this->homeRepository->getAll();
    }

    public function getDoctorsNearYou($perPage = 5, $lat = null, $lng = null)
    {
        return $this->homeRepository->getDoctorsNearYouPaginated($perPage, $lat, $lng);
    }

    public function getDoctorDetails(int $id)
    {
        return $this->homeRepository->findByIdWithRelations($id);
    }

}
