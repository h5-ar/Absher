<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ItemShipping extends Model
{
 
    use HasFactory;
    protected $table = 'item_shipping'; // هنا اسم جدولك الصحيح

    protected $fillable = [
        'material_value',
        'description_item',
        'shipping_id',
        'size',
    ];
    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shipping::class);
    }
}
