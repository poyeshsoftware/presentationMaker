<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed email
 * @property mixed name
 * @property mixed id
 * @property mixed role
 * @property mixed $permissions
 * @property mixed $roles
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role,
            'permissions' => $this->whenLoaded("permissions")

        ];
    }
}
