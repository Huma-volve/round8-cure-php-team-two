<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';
    protected $fillable = [
        'user_id',
        'doctor_id',
        'last_message_at',
    ];
    protected $casts = [
        'last_message_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function favoriteByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_chats');
    }
}
