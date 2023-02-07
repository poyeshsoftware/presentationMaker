<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $slide_id
 * @property mixed $left
 * @property mixed $top
 * @property mixed $width
 * @property mixed $height
 * @property mixed $type
 * @property mixed $link_slide_id
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class ButtonResource extends JsonResource
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
            'slide_id' => $this->slide_id,
            'left' => $this->left,
            'top' => $this->top,
            'width' => $this->width,
            'height' => $this->height,
            'type' => $this->type,
            'link_slide_id' => $this->link_slide_id
        ];
    }
}
