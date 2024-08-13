<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_premium' => $this->is_premium,
            'state_course' => new StateCourseResource($this->whenLoaded('stateCourse')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
