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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
