<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'chat_id',
        'user_id',
        'content',
        'type',
        'seen',
    ];

    protected $casts = [
        'type' => MessageType::class,
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->morphTo();
    }
}
