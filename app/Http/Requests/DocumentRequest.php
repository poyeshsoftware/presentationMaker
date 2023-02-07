<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $project_id
 * @property mixed $file
 */
class DocumentRequest extends FormRequest
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
            'file' => 'required|file|mimes:pdf,doc,docx,txt,csv,xls,xlsx,ppt,pptx,jpg,png,jpeg,gif',
            'project_id' => 'required|integer|exists:projects,id',
        ];
    }
}
