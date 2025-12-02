<?php

namespace App\Http\Controllers\Api\Chat\Search;

use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function searchChats()
    {
        $keyword = request('keyword', 'name');
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = $auth->chats()->with('doctor')
            ->where(function ($query) use ($keyword) {
                $query->whereHas('doctor', fn($q) => $q->where('name', 'like', '%' . $keyword . '%'))
                    ->orWhereHas('messages', fn($q) => $q->where('content', 'like', '%' . $keyword . '%'));
            })->get();

        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }
        return apiResponse(200, 'success', $chat);

    }
}
