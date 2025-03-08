<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = null;
        if (isset($this?->attache?->upload?->url)) {
            $image = asset($this?->attache?->upload?->url);
        }

        return [
            "id"                =>  $this->id,
            "name"              =>  $this->name,
            "last_name"         =>  $this->last_name,
            "email"             =>  $this->email,
            "username"          =>  $this->username,
            "phone_number"      =>  $this->phone_number,
            "gender"            =>  $this->gender,
            "birth_date"        =>  $this->birth_date,
            "points_balance"    =>  $this->points_balance,
            "image"             =>  $image,
        ];
    }
}
