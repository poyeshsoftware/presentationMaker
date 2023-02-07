<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed id
 * @property mixed $order_num
 * @property mixed $type
 * @property mixed $prefix
 * @property mixed $text
 */
class ReferenceRequest extends FormRequest
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
            'slide_id' => 'required|integer|exists:slides,id',
            'order_num' => 'nullable|integer|min:0',
            'type' => 'nullable|integer|min:0',
            'prefix' => 'nullable|string|max:255',
            'text' => 'nullable|string',
        ];
    }
}
