<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'    => $this->name,
            'line_one'    => $this->line_one,
            'line_two'    => $this->line_two,
            'city'    => $this->city,
            'phone'    => $this->phone,
            'description'    => $this->description,
            'long'    => $this->long,
            'lat'    => $this->lat,
            'created_at'    => $this->created_at,
        ];
    }
}
