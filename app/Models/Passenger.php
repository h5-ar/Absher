<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passenger extends Model
{
    use HasFactory;
    public function subscribtion(): BelongsTo
    {
        return $this->belongsTo(Subscribtion::class);
    }
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
