<?php

namespace App\Modules\Favorites\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Modules\Favorites\Services\FavoriteService;
use App\Modules\Favorites\Resources\FavoriteResource;
use App\Modules\Favorites\Requests\ToggleFavoriteRequest;

class FavoriteController extends Controller
{
    public function __construct(
        protected FavoriteService $favoriteService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $favorites = $this->favoriteService->list($user);

        return apiResponse(
            true,
            $favorites->isEmpty() ? 'Your favorite list is empty' : 'Favorites loaded successfully',
            FavoriteResource::collection($favorites)
        );
    }

    public function toggle(ToggleFavoriteRequest $request, Doctor $doctor)
    {
        $user = $request->user();

        $result = $this->favoriteService->toggle($user, $doctor);

        return apiResponse(
            true,
            $result['message'],
            [
                'added'       => $result['added'],
                'is_favorite' => $result['added']
            ]
        );
    }
}
