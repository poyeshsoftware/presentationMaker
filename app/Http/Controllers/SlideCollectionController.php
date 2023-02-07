<?php

namespace App\Http\Controllers;


use App\Http\Requests\SlideCollectionRequest;
use App\Http\Resources\SlideCollectionResource;
use App\Models\Project;
use App\Models\SlideCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Str;

/**
 * @group SlideCollection endpoints
 * @authenticated
 */
class SlideCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Todo: Access control to only let authorized users view or perform crud operations

    /**
     * Display a listing of the slideCollections
     *
     * @apiResourceCollection App\Http\Resources\SlideCollectionResource
     * @apiResourceModel App\Models\SlideCollection
     * @throws AuthorizationException
     */
    public function index(Project $project): AnonymousResourceCollection
    {
        $this->authorize('view', $project);

        return SlideCollectionResource::collection(SlideCollection::query()
            ->where('project_id', $project->id)->get());
    }

    /**
     * Store a newly created SlideCollection in database.
     *
     * @return SlideCollectionResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\SlideCollectionResource
     * @apiResourceModel App\Models\SlideCollection
     */
    public function store(Project $project, SlideCollectionRequest $request)
    {
        $this->authorize('update', $project);

        $slideCollection = SlideCollection::create(
            [
                'project_id' => $project->id,
                'slug' => Str::slug($request->name),
                'name' => $request->name,
                'order_num' => $request->order_num
            ]
        );

        return new SlideCollectionResource($slideCollection->refresh());
    }

    /**
     * Display the specified SlideCollection.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\SlideCollectionResource
     * @apiResourceModel App\Models\SlideCollection
     */
    public function show(Project $project, SlideCollection $slideCollection)
    {
        if ($project->id !== $slideCollection->project_id) {
            abort(404);
        }
        $this->authorize('view', $project);
        return new SlideCollectionResource($slideCollection->refresh());
    }

    /**
     * Update the specified SlideCollection in database.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\SlideCollectionResource
     * @apiResourceModel App\Models\SlideCollection
     */
    public function update(Project $project, SlideCollection $slideCollection, SlideCollectionRequest $request)
    {
        if ($project->id !== $slideCollection->project_id) {
            abort(404);
        }

        $this->authorize('update', $slideCollection->project);
        $slideCollection->update(
            [
                'slug' => Str::slug($request->name),
                'name' => $request->name,
                'order_num' => $request->order_num,
            ]
        );

        return new SlideCollectionResource($slideCollection->refresh());
    }

    /**
     * Remove the specified SlideCollection from database.
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, SlideCollection $slideCollection)
    {
        if ($project->id !== $slideCollection->project_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $slideCollection->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
