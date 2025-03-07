<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }
    public function bus(): HasMany
    {
        return $this->hasMany(Bus::class);
    }
    public function plan(): HasMany
    {
        return $this->hasMany(Plan::class);
    }
    public function trip(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
