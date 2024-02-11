<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentTenantRessource extends JsonResource
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
            'birth_date' => $this->birth_date,
            'email_verified_at' => $this->email_verified_at ?? null,
            'email' => $this->email,
            'profile_picture'=> 'https://api.dicebear.com/7.x/adventurer/svg?seed=Simon',
            'role' => new RoleTenantRessource($this->roles->first()),
            'addresses' => new AddressCollection($this->addresses),
            'avatar'=>'-',
            'number_phones' => new NumberPhoneCollection($this->numberPhone),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
