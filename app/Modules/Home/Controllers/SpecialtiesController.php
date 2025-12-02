<?php

namespace App\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Home\Services\HomeService;

class SpecialtiesController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        return apiResponse(
            true,
            "Specialties loaded successfully",
            [
                "specialties" => $this->homeService->getPaginatedSpecialties(),
            ]
        );
    }
}
