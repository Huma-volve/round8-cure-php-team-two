<?php

namespace App\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
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
        $doctorData = $this->homeService->getDoctorDetails($id);

        return response()->json([
            'status' => true,
            'data' => $doctorData
        ]);
    }
}
