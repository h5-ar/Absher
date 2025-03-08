<?php

namespace App\Http\Resources;

use App\Enums\OfferType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->load('attache');
        $this->loadMissing('stocks');

        $totalPrice = 0;

        foreach ($this->stocks as $stock) {
           $totalPrice +=  $stock->price * $stock->pivot->quantity;
        }
        return [
            'id'               => $this->id,
            'name'             => getTranslation($this->resource, 'name'),
            'type'             => $this->type,
            'start_date'       => $this->start_date,
            'discount_value'   => $this->value ?? 0,
            'end_date'         => $this->end_date,
            'image'            => asset($this->attache?->upload?->url),
            'items_count'      => $this->items_count,
            'gifts_count'      => $this->gifts_count,
            'offer_price'      => $totalPrice,
            'items'            => OfferItemsResource::collection($this->whenLoaded('items')),
            'gifts'            => $this->when($this->type == OfferType::GIFT, OfferItemsResource::collection($this->whenLoaded('gifts'))),
        ];
    }
}
