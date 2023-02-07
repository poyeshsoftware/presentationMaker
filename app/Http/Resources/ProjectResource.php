<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $slug
 * @property mixed $name
 * @property mixed $user
 * @property mixed $id
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $projectUser
 */
class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'user' => new UserResource($this->whenLoaded('user')),
            'project_user' => new UserResource($this->whenLoaded('projectUser')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

    }
}
