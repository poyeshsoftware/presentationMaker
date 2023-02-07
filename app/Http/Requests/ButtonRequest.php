<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed id
 * @property mixed $link_slide_id
 * @property mixed $type
 * @property mixed $width
 * @property mixed $height
 * @property mixed $top
 * @property mixed $left
 */
class ButtonRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'slide_id' => 'required|integer|exists:slides,id',
            'left' => 'required|integer',
            'top' => 'required|integer',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'type' => 'required|integer',
            'link_slide_id' => 'nullable|integer|exists:slides,id',
        ];
    }
}
