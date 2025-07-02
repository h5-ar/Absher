<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
protected $casts = [
    'start_at' => 'datetime',
    'end_at' => 'datetime',
];

    protected $table = 'subscriptions';

    use HasFactory;
    public function plans(): BelongsTo
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
     public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
     public function company(): BelongsTo
    {
        return $this->belongsTo(company::class);
    }
}
