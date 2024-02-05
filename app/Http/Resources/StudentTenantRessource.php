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
            'last_name' => $this->user->last_name,
            'first_name' => $this->user->first_name,
            'middle_names' => $this->user->middle_names,
            'gender' => $this->user->gender,
            'birth_date' => $this->user->birth_date,
            'email_verified_at' => $this->user->email_verified_at ?? null,
            'email' => $this->user->email,
            'profile_picture'=> 'https://api.dicebear.com/7.x/adventurer/svg?seed=Simon',
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
            'role' => new RoleTenantRessource($this->user->roles->first()),
//            'address' => new AddressTenantRessource($this->user->address),
            'avatar'=>'-',
            'address' => [
                'street' => '-',
                'postal_code' => '-',
                'city' => '-',
                'country' => '-',
                'state'=> '-',
            ],
            'phone' => [
                'number' => '-',
                'type' => '-',
            ],
        ];
    }
}
