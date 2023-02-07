<?php

namespace App\Http\Requests;

use App\Models\Slide;
use App\Rules\SlideType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed $order_num
 * @property mixed $parent_id
 * @property mixed $image_id
 * @property mixed $slide_type
 */
class SlideRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string',
            'slide_collection_id' => 'required|integer|exists:slide_collections,id',
            'parent_id' => 'nullable|integer|exists:slides,id',
            'image_id' => 'required|integer|exists:images,id',
            'slide_type' => ['required', 'integer', new SlideType],
            'order_num' => 'nullable|integer',
        ];
    }
}
