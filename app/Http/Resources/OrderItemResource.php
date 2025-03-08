<?php

namespace App\Http\Resources;

use App\Enums\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $priceBeforeDiscount = $this->unit_price;

        if ($this->discount_type == DiscountType::DISCOUNT->value) {
            $priceAfterDiscount = $priceBeforeDiscount - $this->discount_value;
        } else {
            $priceAfterDiscount = $priceBeforeDiscount - (($this->discount_value / 100) * $priceBeforeDiscount);
        }

        return [
            'id'                        => $this->id,
            'price'                     => $priceBeforeDiscount,
            'price_after_discount'      => $priceAfterDiscount,
            'product_quantity'          => $this->product_quantity,
            'image'                     => $this->when($this?->stock?->attache?->upload?->url, asset($this?->stock?->attache?->upload?->url)),
            'is_gift'                   => $this->is_gift,
            'product_name'              => $this?->stock?->product?->name,
            'product_description'       => $this?->stock?->product?->description
        ];
    }
}
