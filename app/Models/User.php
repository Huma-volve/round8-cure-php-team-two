<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;
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

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
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
        return $this->belongsToMany(Chat::class, 'favorite_chats');
    }

    public function favoriteDoctors()
    {
        return $this->belongsToMany(Doctor::class, 'favorites');
    }

    public function searchHistories()
    {
        return $this->hasMany(Search::class);
    }


}
