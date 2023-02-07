<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateRoleRequest extends FormRequest
{
    /**
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function authorize(): bool
    {
        abort_if(Gate::denies('Can Update Roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'required',
                "unique:roles,name," . $this->route('role')->id
            ],
            'permissions.*' => [
                'integer',
            ],
            'permissions' => [
                'required',
                'array',
                'exists:permissions,id'
            ],
        ];
    }
}
