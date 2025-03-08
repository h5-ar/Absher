<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $brand = null;
        $category = null;
        $model = null;
        if ($this->couponable_type != null) {
            $model = $this->couponable_type::with('attache')->find($this->couponable_id);
            $type = strtolower(class_basename($model));

            $$type = $model->name;
        }

        return [
            "id"                => $this->id,
            'name'              => $this->name,
            'code'              => $this->code,
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date,
            'discount_type'     => $this->discount_type,
            'discount_value'    => $this->discount_value,
            'category'          => $category,
            'brand'             => $brand,
            'image'             => asset($model?->attache?->upload?->url),
        ];
    }
}
