<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    
    
    $user= auth()->user();    
    return (int) $user->id === (int) $id;

});

Broadcast::channel('chat.{id}', function ($user, $id) {
    return $user->chats()->where('chats.id', $id)->exists();
});
