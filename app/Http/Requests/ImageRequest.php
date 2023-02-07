<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed type
 * @property mixed image
 * @property mixed $project_id
 * @property mixed $alt
 */
class ImageRequest extends FormRequest
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
            'image' => 'required|image',
            'project_id' => 'required|integer|exists:projects,id',
            'type' => 'required|string',
            'alt' => 'nullable|string',
        ];
    }
}
