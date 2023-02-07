<?php

namespace App\Http\Controllers;

use App\Http\Requests\ButtonRequest;
use App\Http\Resources\ButtonResource;
use App\Models\Button;
use App\Models\Project;
use App\Models\Slide;
use App\Models\SlideCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Str;

/**
 * @group Button endpoints
 * @authenticated
 */
class ButtonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the buttons
     *
     * @apiResourceCollection App\Http\Resources\ButtonResource
     * @apiResourceModel App\Models\Button
     * @throws AuthorizationException
     */
    public function index(Project $project, SlideCollection $slideCollection, Slide $slide): AnonymousResourceCollection
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return ButtonResource::collection(
            Button::query()->where('slide_id', $slide->id)->get()
        );
    }

    /**
     * Store a newly created button in database.
     *
     * @return ButtonResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\ButtonResource
     * @apiResourceModel App\Models\Button
     */
    public function store(Project $project, SlideCollection $slideCollection, Slide $slide, ButtonRequest $request)
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $button = Button::create(
            [
                "slide_id" => $slide->id,
                'left' => $request->left,
                'top' => $request->top,
                "width" => $request->width,
                "height" => $request->height,
                "type" => $request->type,
                'link_slide_id' => $request->link_slide_id
            ]
        );

        return new ButtonResource($button->refresh());
    }

    /**
     * Display the specified button.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\ButtonResource
     * @apiResourceModel App\Models\Button
     */
    public function show(Project $project, SlideCollection $slideCollection, Slide $slide, Button $button)
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id
            || $slide->id != $button->slide_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return new ButtonResource($button->refresh());
    }

    /**
     * Update the specified button in database.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\ButtonResource
     * @apiResourceModel App\Models\Button
     */
    public function update(Project $project, SlideCollection $slideCollection, Slide $slide, Button $button, ButtonRequest $request)
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id
            || $slide->id != $button->slide_id) {
            abort(404);
        }
        $this->authorize('update', $project);

        $button->update(
            [
                'left' => $request->left,
                'top' => $request->top,
                "width" => $request->width,
                "height" => $request->height,
                "type" => $request->type,
                'link_slide_id' => $request->link_slide_id
            ]
        );

        return new ButtonResource($button->refresh());
    }

    /**
     * Remove the specified button from database.
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, SlideCollection $slideCollection, Slide $slide, Button $button)
    {
        if ($project->id != $slideCollection->project_id || $slideCollection->id != $slide->slide_collection_id
            || $slide->id != $button->slide_id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $button->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
