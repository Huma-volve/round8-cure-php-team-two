<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'status',
        'provider_id',
        'location',
        'bir_of_date',
        'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'location' => 'json',

        ];
    }


    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function favoriteChats()
    {
        return $this->hasMany(FavoriteChat::class, 'user_id');
    }

}
