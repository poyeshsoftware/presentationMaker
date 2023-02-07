<?php

namespace App\Http\Controllers;


use App\Http\Requests\SlideCollectionRequest;
use App\Http\Requests\SlideRequest;
use App\Http\Resources\SlideCollectionResource;
use App\Http\Resources\SlideResource;
use App\Models\Image;
use App\Models\Project;
use App\Models\Slide;
use App\Models\SlideCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Str;

/**
 * @group Slide endpoints
 * @authenticated
 */
class SlideController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the slides
     *
     * @apiResourceCollection App\Http\Resources\SlideResource
     * @apiResourceModel App\Models\Slide
     * @throws AuthorizationException
     */
    public function index(Project $project, SlideCollection $slideCollection): AnonymousResourceCollection
    {
        if ($project->id != $slideCollection->project_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return SlideResource::collection(Slide::query()
            ->where("slide_type", Slide::TYPE_SLIDE)
            ->where('slide_collection_id', $slideCollection->id)->get());
    }

    /**
     * Store a newly created slide in database.
     *
     * @return SlideResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\SlideResource
     * @apiResourceModel App\Models\Slide
     */
    public function store(Project $project, SlideCollection $slideCollection, SlideRequest $request)
    {
        $this->authorize('update', $project);
        if ($project->id != $slideCollection->project_id) {
            abort(404);
        }

        if ($request->has("image_id")) {
            $image = Image::find($request->image_id);
            if ($image->project_id != $project->id) {
                abort(404, "Image not found");
            }
        }

        $slide = Slide::create(
            [
                "slide_collection_id" => $slideCollection->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                "parent_id" => $request->parent_id,
                "image_id" => $image->id,
                "slide_type" => $request->slide_type,
                'order_num' => $request->order_num
            ]
        );

        return new SlideResource($slide->refresh());
    }

    /**
     * Display the specified slide.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\SlideResource
     * @apiResourceModel App\Models\Slide
     */
    public function show(Project $project, SlideCollection $slideCollection, Slide $slide)
    {
        if ($project->id !== $slideCollection->project_id || $slideCollection->id !== $slide->slide_collection_id) {
            abort(404);
        }
        $this->authorize('view', $project);

        return new SlideResource($slide->refresh());
    }

    /**
     * Update the specified slide in database.
     *
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\SlideResource
     * @apiResourceModel App\Models\Slide
     */
    public function update(Project $project, SlideCollection $slideCollection, Slide $slide, SlideRequest $request)
    {

        if ($project->id !== $slideCollection->project_id ||
            $slideCollection->id !== $slide->slide_collection_id
        ) {
            abort(404);
        }

        $this->authorize('update', $project);

        if ($request->has("image_id")) {
            $image = Image::where("project_id", $project->id)->where("id", $request->image_id)->first();
            if (!$image) {
                abort(404, "Image not found");
            }
        }


        $slide->update(
            [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                "image_id" => $request->image_id,
                "slide_type" => $request->slide_type,
                'order_num' => $request->order_num
            ]
        );

        return new SlideResource($slide->refresh());
    }

    /**
     * Remove the specified slide from database.
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, SlideCollection $slideCollection, Slide $slide)
    {
        if ($project->id !== $slideCollection->project_id || $slide->slide_collection_id !== $slideCollection->id) {
            abort(404);
        }

        $this->authorize('update', $project);

        $slide->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
