<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class CategoryResource extends JsonResource
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
            'name'      =>  getTranslation($this->resource, 'name'),
            'gender'    =>  $this->gender,
            'image'     =>  asset($this?->attache?->upload?->url),
            'children'  =>  $this->whenLoaded('children', self::collection($this->children)),
        ];
    }
}
