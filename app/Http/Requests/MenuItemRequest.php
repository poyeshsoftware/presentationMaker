<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $order_num
 * @property mixed $link_slide_id
 * @property mixed $type
 */
class MenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'menu_category_id' => 'required|integer|exists:menu_categories,id',
            'order_num' => 'nullable|integer',
            'link_slide_id' => 'nullable|integer|exists:slides,id',
            'type' => 'nullable|integer',
            'style' => 'nullable|string',
        ];
    }
}
