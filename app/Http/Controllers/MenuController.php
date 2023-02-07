<?php

namespace App\Http\Controllers;


use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Project;
use App\Models\Menu;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Menu endpoints
 * @authenticated
 */
class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the Menu.
     *
     * @apiResourceCollection App\Http\Resources\MenuResource
     * @apiResourceModel App\Models\Menu
     * @throws AuthorizationException
     */
    public function index(Project $project): AnonymousResourceCollection
    {
        $this->authorize('view', $project);

        return MenuResource::collection(Menu::query()
            ->where('project_id', $project->id)->get());
    }

    /**
     * Store a newly created Menu in database.
     *
     * @return MenuResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuResource
     * @apiResourceModel App\Models\Menu
     */
    public function store(Project $project, MenuRequest $request)
    {
        $this->authorize('update', $project);

        $menu = Menu::create(
            [
                'project_id' => $project->id,
                'name' => $request->name,
                'type' => $request->type
            ]
        );

        return new MenuResource($menu->refresh());
    }

    /**
     * Display the specified Menu.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuResource
     * @apiResourceModel App\Models\Menu
     */
    public function show(Project $project, Menu $menu)
    {
        if ($project->id !== $menu->project_id) {
            abort(404);
        }
        $this->authorize('view', $project);
        return new MenuResource($menu->refresh());
    }

    /**
     * Update the specified Menu in database.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuResource
     * @apiResourceModel App\Models\Menu
     */
    public function update(Project $project, Menu $menu, MenuRequest $request)
    {
        if ($project->id !== $menu->project_id) {
            abort(404);
        }

        $this->authorize('update', $menu->project);
        $menu->update(
            [
                'name' => $request->name,
                'type' => $request->type,
            ]
        );

        return new MenuResource($menu->refresh());
    }

    /**
     * Remove the specified Menu from database.
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, Menu $menu)
    {
        if ($project->id !== $menu->project_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $menu->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
