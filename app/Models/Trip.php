<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Trip extends Model
{
    use HasFactory;
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }
    public function path(): HasOne
    {
        return $this->hasOne(Path::class);
    }
    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
    public function shipping(): HasMany
    {
        return $this->hasMany(Shipping::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
