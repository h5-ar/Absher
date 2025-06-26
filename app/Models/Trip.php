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
    protected $fillable = [
        'price',
        'bus_id',
        'company_id',
        'take_off_at',

    ];
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
    public function reservedSeatsCount()
    {
        return $this->reservations()->sum('count_seat');
    }
}
