<?php

namespace App\Http\Resources;

use App\Enums\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VarianceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $priceBeforeDiscount = $this->price;

        if ($this->discount_type == DiscountType::DISCOUNT->value) {
            $priceAfterDiscount = $priceBeforeDiscount - $this->discount_value;
            $discountValueInPercentage =  100 - (($priceAfterDiscount * 100) / $priceBeforeDiscount);
        } else {
            $priceAfterDiscount = $priceBeforeDiscount - (($this->discount_value / 100) * $priceBeforeDiscount);
            $discountValueInPercentage = $this->discount_value;
        }

        $this->load('attaches');
        $this->load('attache');
        $images = $this->resource->attaches->map(fn ($image) => asset($image->url))->toArray();
        return [
            'id'                           => $this->id,
            'product_id'                   => $this->product_id,
            'variant'                      => $this->variant,
            'sku'                          => $this->sku,
            'price'                        => $priceBeforeDiscount,
            'price_after_discount'         => (int) round($priceAfterDiscount),
            'discount_value'               => round($discountValueInPercentage, 2),
            'qty'                          => $this->qty,
            'color'                        => $this->variant['color'],
            'image'                        => $this->when($this?->attache?->upload?->url, asset($this?->attache?->upload?->url)),
            'images'                       => $images,
        ];
    }
}
