<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->load('attache');
        return [
            'id'                => $this->id,
            'image'             => asset($this?->attache?->upload?->url),
            'type'              => $this->type,
            // 'start_date'        => $this->start_date,
            // 'end_date'          => $this->end_date,
            'product_id'        => $this->product_id,
            'category_id'       => $this->category_id,
            'sub_category_id'   => $this->sub_category_id,
            'brand_id'          => $this->brand_id,
        ];
    }
}
