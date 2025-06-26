<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passenger extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id',
        'first_name',
        'father_name',
        'last_name',
        'subscribtion_id',
        'seat_number'
    ];
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
