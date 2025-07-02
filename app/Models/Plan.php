<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;


class Plan extends Model
{
    use Notifiable;

    use HasFactory;

    protected $fillable = [
        'name',
        'trips_number',
        'type_bus',
        'available',
        'price',
        'form',
        'to',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
public function bus()
{
    return $this->belongsTo(Bus::class, 'bus_id'); 
}

}
