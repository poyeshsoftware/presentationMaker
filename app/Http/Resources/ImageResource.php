<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed address
 * @property mixed id
 * @property mixed file_name
 * @property mixed $alt
 */
class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'address' => Image::getAddress($this),
            'name' => $this->file_name,
            'alt' => $this->alt,
        ];
    }
}
