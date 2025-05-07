<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscribtion extends Model
{
    use HasFactory;
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
    public function passenger(): HasMany
    {
        return $this->hasMany(Passenger::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
