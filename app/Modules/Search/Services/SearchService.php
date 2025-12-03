<?php

namespace App\Modules\Search\Services;

use App\Models\Search;

class SearchService
{
    public function saveSearchHistory($userId, $keyword)
    {
        if (!$keyword) return;

        Search::updateOrCreate(
            ['user_id' => $userId, 'content' => $keyword],
            ['updated_at' => now()]
        );
    }
}
