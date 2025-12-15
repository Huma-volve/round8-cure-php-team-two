<?php

namespace App\Http\Controllers\Dashboard\Doctor\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Auth::guard('doctor')->user()
            ->chats()->with(['lastMessage',
             'doctor',
             'user' => fn($q) => $q->select('id', 'name' , 'image'),
            'messages' => fn($q) => $q->whereSeen(0)->select('id', 'seen')])
            ->get();
        $favChats = Auth::guard('doctor')->user()->favoriteChats()
        ->with([ 'user' => fn($q) => $q->select('id', 'name' , 'image')
         , 'lastMessage' ,
          'messages' => fn($q) => $q->whereSeen(0)->select('id', 'seen')])->get();

        return view('doctor.chat.index', compact('chats', 'favChats'));
    }

    public function showChat() {}
}
