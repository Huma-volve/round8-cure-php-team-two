<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class
FavoriteChat extends Model
{
    protected $table = 'favorite_chats';
    protected $fillable = [
        'user_id',
        'chat_id',
    ];

}
