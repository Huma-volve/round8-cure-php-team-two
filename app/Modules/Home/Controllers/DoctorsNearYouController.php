<?php

namespace App\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Home\Services\HomeService;

class DoctorsNearYouController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $perPage = request()->get('per_page', 5);

        return response()->json([
            "status" => true,
            "message" => "Home data loaded",
            "data" => [
                "doctors_near_you" => $this->homeService->getDoctorsNearYou($perPage),
            ]
        ]);
    }
}
