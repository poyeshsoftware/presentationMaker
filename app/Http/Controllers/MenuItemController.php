<?php

namespace App\Http\Controllers;


use App\Http\Requests\MenuItemRequest;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Project;
use App\Models\Menu;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group MenuItem endpoints
 * @authenticated
 */
class MenuItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the MenuItems.
     *
     * @apiResourceCollection App\Http\Resources\MenuItemResource
     * @apiResourceModel App\Models\MenuItem
     * @throws AuthorizationException
     */
    public function index(Project $project, Menu $menu, MenuCategory $menuCategory): AnonymousResourceCollection
    {
        if ($project->id != $menu->project_id || $menu->id != $menuCategory->menu_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return MenuItemResource::collection(MenuItem::query()
            ->where('menu_category_id', $menuCategory->id)->get());
    }

    /**
     * Store a newly created MenuItem in database.
     *
     * @return MenuItemResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuItemResource
     * @apiResourceModel App\Models\MenuItem
     */
    public function store(Project $project, Menu $menu, MenuCategory $menuCategory, MenuItemRequest $request)
    {
        if ($project->id != $menu->project_id || $menu->id != $menuCategory->menu_id) {
            abort(404);
        }
        $this->authorize('update', $project);

        $menuItem = MenuItem::create(
            [
                'name' => $request->name,
                'menu_category_id' => $menuCategory->id,
                'order_num' => $request->order_num,
                'link_slide_id' => $request->link_slide_id,
                'type' => $request->type,
                'style' => $request->style ?? '',
            ]
        );

        return new MenuItemResource($menuItem->refresh());
    }

    /**
     * Display the specified MenuItem.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuItemResource
     * @apiResourceModel App\Models\MenuItem
     */
    public function show(Project $project, Menu $menu, MenuCategory $menuCategory, MenuItem $menuItem)
    {
        if ($project->id !== $menu->project_id || $menu->id !== $menuCategory->menu_id || $menuCategory->id !== $menuItem->menu_category_id) {
            abort(404);
        }

        $this->authorize('view', $project);

        return new MenuItemResource($menuItem->refresh());
    }

    /**
     * Update the specified MenuItem in database.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuItemResource
     * @apiResourceModel App\Models\MenuItem
     */
    public function update(Project $project, Menu $menu, MenuCategory $menuCategory, MenuItem $menuItem, MenuItemRequest $request)
    {
        if ($project->id !== $menu->project_id || $menu->id !== $menuCategory->menu_id || $menuCategory->id !== $menuItem->menu_category_id) {
            abort(404);
        }

        $this->authorize('update', $menu->project);
        $menuItem->update(
            [
                'name' => $request->name,
                'order_num' => $request->order_num,
                'link_slide_id' => $request->link_slide_id,
                'type' => $request->type,
                'style' => $request->style ?? '',
            ]
        );

        return new MenuItemResource($menuItem->refresh());
    }

    /**
     * Remove the specified MenuItem from database.
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, Menu $menu, MenuCategory $menuCategory, MenuItem $menuItem)
    {
        if ($project->id !== $menu->project_id || $menu->id !== $menuCategory->menu_id || $menuCategory->id !== $menuItem->menu_category_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $menuItem->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
