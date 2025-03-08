<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"                                => $this->id,
            "status"                            => $this->status,
            "address"                           => $this->address,
            "price"                             => $this->total_price - $this->discount,
            "total_price"                       => ($this->total_price + $this->shipping_cost + $this->tax) - $this->discount,
            "items_count"                       => $this->order_items_sum_product_quantity,
            "shipping_cost"                     => $this->shipping_cost,
            "tax"                               => $this->tax,
            "submitted_on"                      => $this->created_at->format('Y-m-d'),
            "item"                              => OrderItemResource::make($this->whenLoaded('orderItem')),
            "items"                             => OrderItemResource::collection($this->whenLoaded('orderItems'))->resource,
        ];
    }
}
