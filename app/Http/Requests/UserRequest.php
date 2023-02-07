<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed password
 * @property mixed role
 */
class UserRequest extends FormRequest
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
        $req = [
            'name' => 'required|string',
            'email' => 'required|email',
            'role' => 'integer|min:0|max:10'
        ];

        if ($this->has('password')) {
            $req['password'] = 'required|min:6';
            $req['password_confirm'] = 'required|same:password';
        }

        return $req;
    }
}
