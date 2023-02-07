<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $format
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $project_id
 */
class DocumentResource extends JsonResource
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
            "project_id" => $this->project_id,
            'name' => $this->name,
            "address" => URL::to('/') . '/storage/' . $this->project_id . "/documents/" . $this->format . "/" . $this->name,
            'format' => $this->format
        ];
    }
}
