<?php

namespace App\Modules\Search\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Search\Repositories\SearchRepository;
use App\Modules\Search\Requests\SearchRequest;
use App\Modules\Search\Resources\DoctorResource;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(protected SearchRepository $repository) {}

    protected function getUser(Request $request)
    {
        return $request->user() ?? abort(401, 'User not authenticated');
    }

    public function search(SearchRequest $request)
    {
        $user = $this->getUser($request);

        $keyword = $request->input('content');
        $this->repository->saveSearchHistory($user->id, $keyword);
        $doctors = $this->repository->searchDoctors($keyword);

        return apiResponse(
            true,
            'Search results loaded successfully',
            DoctorResource::collection($doctors)
        );
    }

    public function history(Request $request)
    {
        $user = $this->getUser($request);
        $history = $this->repository->getUserHistory($user->id);

        return apiResponse(
            true,
            'Search history loaded successfully',
            $history
        );
    }

    public function clearHistory(Request $request)
    {
        $user = $this->getUser($request);
        $this->repository->clearUserHistory($user->id);

        return apiResponse(
            true,
            'Search history cleared'
        );
    }
}
