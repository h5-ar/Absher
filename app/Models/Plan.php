<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trips_number',
        'type_bus',
        'available',
        'price',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function subscribtion(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
