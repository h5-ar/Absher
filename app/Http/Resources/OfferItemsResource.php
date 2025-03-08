<?php

namespace App\Http\Resources;

use App\Models\OfferItem;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->stock->load('attache');
        return [
            'id'            => $this->id,
            'stock_id'      => $this->product_stock_id,
            'product_id'    => $this->stock->product_id,
            'name'          => $this->stock?->product?->name,
            'description'   => $this->stock?->product?->description,
            'quantity'      => $this->quantity,
            'price'         => $this->stock->price * $this->quantity,
            'color'         => $this->stock->variant['color'] ?? null,
            'size'          => $this->stock->variant['size'] ?? null,
            'image'         => asset($this->stock?->attache?->upload?->url),
        ];
    }
}
