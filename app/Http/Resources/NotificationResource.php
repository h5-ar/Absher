<?php

namespace App\Http\Resources;

use App\Enums\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->data['title'] ?? '',
            'body' => $this->data['body'] ?? '',
            'content_type' => (string) NotificationType::matchEnum($this->data['content_type'])?->value ?? '',
            'content_id' => (string) $this->data['content_id'] ?? '',
            'created_at' => $this->created_at?->format('Y-m-d:H:i:s'),
        ];
    }
}
