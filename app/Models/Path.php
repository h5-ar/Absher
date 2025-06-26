<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Path extends Model
{
    use HasFactory;

    protected $appends = ['last_destination'];
protected $casts = [
        'type' => 'string',
    ];
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
    public function getLastDestinationAttribute()
    {
        // البحث عن آخر وجهة غير فارغة
        if (!empty($this->to5)) return $this->to5;
        if (!empty($this->to4)) return $this->to4;
        if (!empty($this->to3)) return $this->to3;
        if (!empty($this->to2)) return $this->to2;
        return $this->to1; // الوجهة الأساسية
    }
}
