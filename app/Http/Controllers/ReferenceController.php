<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReferenceRequest;
use App\Http\Resources\ReferenceResource;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Slide;
use App\Models\SlideCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Reference endpoints
 * @authenticated
 */
class ReferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the references
     *
     * @apiResourceCollection App\Http\Resources\ReferenceResource
     * @apiResourceModel App\Models\Reference
     * @throws AuthorizationException
     */
    public function index(Project $project, SlideCollection $slideCollection, Slide $slide): AnonymousResourceCollection
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return ReferenceResource::collection(
            Reference::query()->where('slide_id', $slide->id)->get()
        );
    }

    /**
     * Store a newly created reference in database.
     *
     * @return ReferenceResource
     * @throws AuthorizationException
     */
    public function store(Project $project, SlideCollection $slideCollection, Slide $slide, ReferenceRequest $request)
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $reference = Reference::create(
            [
                "slide_id" => $slide->id,
                'order_num' => $request->order_num,
                'type' => Reference::TYPE_TEXT,
                "prefix" => $request->prefix,
                "text" => $request->text
            ]
        );

        return new ReferenceResource($reference->refresh());
    }

    /**
     * Display the specified reference.
     *
     * @throws AuthorizationException
     */
    public function show(Project $project, SlideCollection $slideCollection, Slide $slide, Reference $reference)
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id
            || $slide->id != $reference->slide_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return new ReferenceResource($reference->refresh());
    }

    /**
     * Update the specified reference in database.
     *
     * @throws AuthorizationException
     */
    public function update(Project $project, SlideCollection $slideCollection, Slide $slide, Reference $reference, ReferenceRequest $request)
    {
        if (
            $project->id != $slideCollection->project_id ||
            $slideCollection->id != $slide->slide_collection_id ||
            $slide->id != $reference->slide_id
        ) {
            abort(404);
        }
        $this->authorize('update', $project);

        $reference->update(
            [
                'order_num' => $request->order_num,
                'type' => Reference::TYPE_TEXT,
                "prefix" => $request->prefix,
                "text" => $request->text
            ]
        );

        return new ReferenceResource($reference->refresh());
    }

    /**
     * Remove the specified reference from database.
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, SlideCollection $slideCollection, Slide $slide, Reference $reference)
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id
            || $slide->id != $reference->slide_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $reference->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
