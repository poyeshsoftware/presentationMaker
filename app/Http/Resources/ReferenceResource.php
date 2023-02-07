<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $slide_id
 * @property mixed $order_num
 * @property mixed $type
 * @property mixed $prefix
 * @property mixed $text
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class ReferenceResource extends JsonResource
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
            'order_num' => $this->order_num,
            'type' => $this->type,
            'prefix' => $this->prefix,
            'text' => $this->text
        ];
    }
}
