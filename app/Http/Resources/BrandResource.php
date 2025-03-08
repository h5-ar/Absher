<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'id'        =>  $this->id,
            'name'      =>  getTranslation($this->resource,'name'),
            'image'     =>  asset($this?->attache?->upload?->url),
        ];

    }
}
