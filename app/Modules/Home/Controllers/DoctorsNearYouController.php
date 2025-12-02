<?php

namespace App\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Home\Services\HomeService;
use Illuminate\Http\Request;

class DoctorsNearYouController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function allDoctors()
    {
        $perPage = request()->get('per_page', 5);
        $lat = request()->get('lat'); // latitude المستخدم
        $lng = request()->get('lng'); // longitude المستخدم

        return response()->json([
            "status" => true,
            "message" => "doctors near you loaded successfully",
            "data" => [
                "doctors_near_you" => $this->homeService->getDoctorsNearYou($perPage, $lat, $lng),
            ]
        ]);
    }

    public function doctorsNearYou(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $lat = $request->input('lat');
        $lng = $request->input('lng');


        return response()->json([
            "status" => true,
            "message" => "doctors near you loaded successfully",
            "data" => [
                "doctors_near_you" => $this->homeService->getDoctorsNearYou($perPage, $lat, $lng),
            ]
        ]);
    }

}
