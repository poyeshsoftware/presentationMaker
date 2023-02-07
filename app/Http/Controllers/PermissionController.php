<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group User Permission endpoints
 * @authenticated
 */
class PermissionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Can Manage Permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Permission::all();
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('Can Manage Permissions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $permission;
    }
}
