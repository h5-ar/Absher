<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Company extends Authenticatable
{

    use Notifiable;

    protected $casts = [
        'password' => "hashed"
    ];
    protected $fillable = [
        'name',
        'phone',
        'email',
        'username',
        'password',
        'description',
        'image',
        'manager_id',
    ];
    use HasFactory;
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }
    public function bus(): HasMany
    {
        return $this->hasMany(Bus::class);
    }
    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
    public function subscriptions()
    {
        return $this->hasManyThrough(Subscription::class, Plan::class);

    }

}
