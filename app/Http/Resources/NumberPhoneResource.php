<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NumberPhoneResource extends JsonResource
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
            'user_id' => $this->whenLoaded('users', $this->user_id),
            'number_phone' => $this->number_phone,
            'type' => $this->type,
            'is_default' => $this->is_default,
            'country_code' => $this->country_code,
            'area_code' => $this->area_code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
