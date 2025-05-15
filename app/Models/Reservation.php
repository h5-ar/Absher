<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'trip_id',
        'user_id', // يمكن أن يكون null
        'count_seats',
        'company_id',
        'source'
    ];
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
    public function passengers(): HasMany
    {
        return $this->HasMany(Passenger::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
