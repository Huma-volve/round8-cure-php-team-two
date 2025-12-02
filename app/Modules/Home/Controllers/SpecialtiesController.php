<?php

namespace App\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Home\Services\HomeService;

class SpecialtiesController extends Controller
{
    protected $homeSrvice;

    public function __construct(HomeService $homeSrvice)
    {
        $this->homeSrvice = $homeSrvice;
    }

    public function index()
    {
        $perPage = request()->get('per_page', 10);

        return response()->json([
            "status" => true,
            "message" => "Home data loaded",
            "data" => [
                "specialties" => $this->homeSrvice->getPaginatedSpecialties($perPage),
            ]
        ]);
    }
}
