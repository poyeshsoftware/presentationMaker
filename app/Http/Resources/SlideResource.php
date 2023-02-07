<?php

namespace App\Http\Resources;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $slug
 * @property mixed $slide_collection_id
 * @property mixed $image_id
 * @property mixed $parent_id
 * @property mixed $slide_type
 * @property mixed $order_num
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $children
 */
class SlideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $popups = $this?->children->where('slide_type', Slide::TYPE_POPUP);
        $frames = $this?->children->where('slide_type', Slide::TYPE_FRAME);

        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'slide_collection' => new SlideCollectionResource($this->whenLoaded('slideCollection')),
            'image' => new ImageResource($this->whenLoaded('image')),
            'slide_type' => $this->slide_type,
            'order_num' => $this->order_num,
            // load children if loaded
            "popups" => SlideResource::collection($popups),
            "frames" => SlideResource::collection($frames),
            "scrolls" => ScrollResource::collection($this->whenLoaded('scrolls')),
            "references" => ReferenceResource::collection($this->whenLoaded('references')),
            "tracking_code" => new TrackingCodeResource($this->whenLoaded('trackingCode')),
        ];
    }
}
