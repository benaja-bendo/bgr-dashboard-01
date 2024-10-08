<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTenantResource extends JsonResource
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
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_names' => $this->middle_names,
            'gender' => $this->gender,
            'avatar' => url($this->avatar),
            'birth_date' => $this->birth_date,
            'addresses' => new AddressCollection($this->addresses),
            'number_phones' => new NumberPhoneCollection($this->numberPhone),
            'email_verified_at' => $this->email_verified_at ?? null,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => new RoleTenantResource($this->roles->first()),
        ];
    }
}
