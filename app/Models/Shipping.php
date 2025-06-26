<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shipping';
    protected $fillable = [

        'shipment_status',
        'user_id',
        'national_number_user_to',
        'phone_user_to',
        'name_user_to',
        'trip_id',
    ];
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function item_Shipping(): HasMany
    {
        return $this->hasMany(ItemShipping::class);
    }
}
