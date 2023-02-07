<?php

namespace App\Http\Controllers;


use App\Http\Requests\MenuCategoryRequest;
use App\Http\Resources\MenuCategoryResource;
use App\Models\MenuCategory;
use App\Models\Project;
use App\Models\Menu;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group MenuCategory endpoints
 * @authenticated
 */
class MenuCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the MenuCategories.
     *
     * @apiResourceCollection App\Http\Resources\MenuCategoryResource
     * @apiResourceModel App\Models\MenuCategory
     * @throws AuthorizationException
     */
    public function index(Project $project, Menu $menu): AnonymousResourceCollection
    {
        if ($project->id != $menu->project_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return MenuCategoryResource::collection(MenuCategory::query()
            ->where('menu_id', $menu->id)->get());
    }

    /**
     * Store a newly created Menu in database.
     *
     * @return MenuCategoryResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuCategoryResource
     * @apiResourceModel App\Models\MenuCategory
     */
    public function store(Project $project, Menu $menu, MenuCategoryRequest $request)
    {
        if ($project->id != $menu->project_id) {
            abort(404);
        }
        $this->authorize('update', $project);

        $menuCategory = MenuCategory::create(
            [
                'menu_id' => $menu->id,
                'order_num' => $request->order_num,
                'name' => $request->name,
                'type' => $request->type,
                'style' => $request->style ?? '',
                'link_slide_id' => $request->link_slide_id
            ]
        );

        return new MenuCategoryResource($menuCategory->refresh());
    }

    /**
     * Display the specified Menu.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuCategoryResource
     * @apiResourceModel App\Models\MenuCategory
     */
    public function show(Project $project, Menu $menu, MenuCategory $menuCategory)
    {
        if ($project->id !== $menu->project_id || $menu->id !== $menuCategory->menu_id) {
            abort(404);
        }

        $this->authorize('view', $project);

        return new MenuCategoryResource($menuCategory->refresh());
    }

    /**
     * Update the specified Menu in database.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\MenuCategoryResource
     * @apiResourceModel App\Models\MenuCategory
     */
    public function update(Project $project, Menu $menu, MenuCategory $menuCategory, MenuCategoryRequest $request)
    {
        if ($project->id !== $menu->project_id || $menu->id !== $menuCategory->menu_id) {
            abort(404);
        }

        $this->authorize('update', $menu->project);
        $menuCategory->update(
            [
                'order_num' => $request->order_num,
                'name' => $request->name,
                'type' => $request->type,
                'style' => $request->style ?? '',
                'link_slide_id' => $request->link_slide_id
            ]
        );

        return new MenuCategoryResource($menuCategory->refresh());
    }

    /**
     * Remove the specified Menu from database.
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, Menu $menu, MenuCategory $menuCategory)
    {
        if ($project->id !== $menu->project_id || $menu->id !== $menuCategory->menu_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $menuCategory->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
