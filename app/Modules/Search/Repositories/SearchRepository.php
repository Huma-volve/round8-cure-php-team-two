<?php

namespace App\Modules\Search\Repositories;

use App\Models\Doctor;
use App\Models\Search;
use Illuminate\Database\Eloquent\Collection;

class SearchRepository
{

    public function getAllDoctors(int $limit = 20)
    {
        return Doctor::query()
            ->with('specialty')
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }
    public function searchDoctors(string $keyword, int $limit = 20): Collection
    {
        return Doctor::query()
            ->where('name', 'LIKE', "%$keyword%")
            ->orWhereHas('specialty', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            })
            ->limit($limit)
            ->get();
    }

    public function saveSearchHistory(int $userId, string $keyword): void
    {
        if (!$keyword) return;

        Search::updateOrCreate(
            ['user_id' => $userId, 'content' => $keyword],
            ['updated_at' => now()]
        );
    }

    public function getUserHistory(int $userId, int $limit = 10)
    {
        return Search::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function clearUserHistory(int $userId): void
    {
        Search::where('user_id', $userId)->delete();
    }
}
