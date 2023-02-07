<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $order_num
 * @property mixed $name
 * @property mixed $type
 * @property mixed $style
 * @property mixed $link_slide_id
 */
class MenuCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'menu_id' => 'required|integer|exists:menus,id',
            'order_num' => 'integer|min:0',
            'type' => 'integer|min:0',
            'style' => 'string|max:255',
            'link_slide_id' => 'nullable|integer|exists:slides,id'
        ];
    }
}
