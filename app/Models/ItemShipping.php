<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ItemShipping extends Model
{
    use HasFactory;
    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shipping::class);
    }
}
