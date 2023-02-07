<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @group User Roles endpoints
 * @authenticated
 */
class RoleController extends Controller
{
    /**
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function index()
    {
        abort_if(Gate::denies('Can Manage Roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Role::paginate(12);
    }

    public function create()
    {
        abort_if(Gate::denies('Can Create Roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Permission::all()->pluck('name', 'id');
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return $role;
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return $role;
    }

    /**
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('Can Delete Roles'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($role->delete()) return $role;
    }
}
