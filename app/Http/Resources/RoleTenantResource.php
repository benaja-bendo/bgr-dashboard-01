<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleTenantResource extends JsonResource
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
            'type' => $this->name,
//            TODO: Uncomment this when permissions are implemented
//            'permissions' => $this->permissions->map(function ($permission) {
//                return [
//                    'id' => $permission->id,
//                    'name' => $permission->name,
//                ];
//            }),
        ];
    }
}
