<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Notifiable هنا تأكد من وجود 

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function subscribtion(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function shipping(): HasMany
    {
        return $this->hasMany(Shipping::class);
    }
}
