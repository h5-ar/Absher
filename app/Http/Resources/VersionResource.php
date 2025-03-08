<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'version'     => $this->version,
            'published'   => (bool)$this->published,
            'currency'    => $this->currency,
            'url'         => $this->url,
            'platform'    => $this->platform,
        ];
    }
}
