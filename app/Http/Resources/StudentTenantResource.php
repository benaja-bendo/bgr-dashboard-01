<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentTenantResource extends JsonResource
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
            'matriculate' => $this->studentInfos->matriculate ?? null,
            'full_name' => $this->first_name . ' ' . $this->last_name, // TODO: Change this to 'full_name' => $this->full_name, when full_name is implemented
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_names' => $this->middle_names,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'email_verified_at' => $this->email_verified_at ?? null,
            'email' => $this->email,
            'role' => new RoleTenantResource($this->roles->first()),
            'addresses' => new AddressCollection($this->addresses),
            'avatar'=> url($this->avatar),
            'number_phones' => new NumberPhoneCollection($this->numberPhone),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
