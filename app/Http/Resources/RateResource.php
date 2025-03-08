<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];
        foreach ($this->attaches as $image) {
            $images[] = asset($image->url);
        }
        $profile = $this->user->attache?->upload?->url;
        return [
            'id'                => $this->id,
            'comment'           => $this->comment,
            'rate'              => $this->rate,
            'user_id'           => $this->user->id,
            'user_fullname'     => $this->user->fullName,
            'user_image'        => $profile ? asset($this->user->attache?->upload?->url) : null,
            'images'            => $images,
        ];
    }
}
