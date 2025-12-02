<?php

namespace App\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Home\Resources\DoctorDetailsResource;
use App\Modules\Home\Services\HomeService;

class DoctorDetailsController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function show($id)
    {
        $doctor = $this->homeService->getDoctorDetails($id);

        return apiResponse(
            true,
            'Doctor details loaded successfully',
            new DoctorDetailsResource($doctor)
        );
    }
}
