<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $menu_id
 * @property mixed $order_num
 * @property mixed $type
 * @property mixed $style
 * @property mixed $link_slide_id
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class MenuCategoryResource extends JsonResource
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
            'menu_id' => $this->menu_id,
            'order_num' => $this->order_num,
            'type' => $this->type,
            'style' => $this->style,
            'link_slide_id' => $this->link_slide_id,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at
        ];
    }
}
