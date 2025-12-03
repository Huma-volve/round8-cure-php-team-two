<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'status',
        'provider_id',
        'location',
        'gender',
        'hospital_name',
        'price',
        'exp_years',
        'specialty_id',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'location' => 'json',
        'status' => 'boolean',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }

    public function times()
    {
        return $this->hasMany(DoctorTime::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // average rating attribute
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class , 'doctor_id');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favoritedByUsers()->where('user_id', $user->id)->exists();
    }
}
