<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;
use App\Http\Resources\VarianceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'                 => $this->id,
            'category_id'        => $this->category_id,
            'name'               => $this->name,
            'description'        => $this->description,
            'recoverable'        => $this->recoverable,
            'recovery_duration'  => $this->recovery_duration,
            'tags'               => $this->tags,
            'slug'               => $this->slug,
            'unit'               => $this->unit,
            'flash_deal'         => $this->flash_deal,
            'min_quantity'       => $this->min_quantity,
            'max_quantity'       => $this->max_quantity,
            'min_order'          => $this->min_order,
            'max_order'          => $this->max_order,
            'category'           => CategoryResource::make($this->whenLoaded('category')),
            'variant'            => VarianceResource::make($this->whenLoaded('firstStock')),
            'brand'              => BrandResource::make($this->whenLoaded('brand')),
        ];
    }
}
