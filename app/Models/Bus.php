<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
protected $hidden = [''];

    protected $fillable = [
        'type',
        'seats_count',
    ];
    protected $fillable = ['number', 'seats', 'type', 'company_id'];
    use HasFactory;
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'Company_id');
    }


    public function trip(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
