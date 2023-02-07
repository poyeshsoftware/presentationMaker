<?php

namespace App\Http\Controllers;

use App\Events\NewImageUploadedEvent;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

/**
 * @group Image endpoints
 * @authenticated
 */
class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the Categories.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ImageResource::collection(Image::get());
    }

    /**
     * Store a newly created Category.
     * @authenticated
     * @param ImageRequest $request
     * @return ImageResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(ImageRequest $request): JsonResponse|ImageResource
    {
        $project = Project::find($request->project_id);

        $this->authorize('update', $project);

        if (!(
            $request->type === Image::SRC_SLIDE_THUMBNAIL ||
            $request->type === Image::SRC_SLIDES
        )) {
            return response()->json([
                'error' => "Image type does not exist !"
            ], 401);
        }

        // primary ID

        if ($request->hasfile('image')) {
            $imageName = $request->type . '_' . time() . '_'
                . md5($request->file('image')->getClientOriginalName())
                . "." . $request->file('image')->getClientOriginalExtension(); // '.webp';

            $s3 = Storage::disk('local');

            $folder = $this->getImageSourceFolder($request->type);

            $filePath = "/" . $request->project_id . "/" . $folder . "/" . $imageName;

            $img = ImageIntervention::make(file_get_contents($request->file('image')));

            $s3->put("/public/" . $filePath, $img->encode(), 'public');


            $image = Image::create([
                'file_name' => $imageName,
                'project_id' => $request->project_id,
                'address' => $filePath,
                'type' => $request->type,
                'height' => $img->height(),
                'width' => $img->width(),
                'format' => $request->file('image')->getClientOriginalExtension(), //'webp',
                'alt' => $request->alt ? $request->alt : ""
            ]);

            // create an event to make all the related thumbnails
            NewImageUploadedEvent::dispatch($image);
            return new ImageResource($image);

        } else {
            return response()->json([
                'error' => 'Error, no image to upload!'
            ], 401);
        }

    }

    /**
     * Display the specified Category.
     *
     * @param Image $image
     * @return ImageResource
     */
    public function show(Image $image): ImageResource
    {
        return new ImageResource($image);
    }

    /**
     * Remove the specified Category.
     * @authenticated
     * @param Image $image
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Image $image): JsonResponse
    {
        $project = Project::find($image->project_id);

        $this->authorize('update', $project);

        $image->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful',
        ]);

    }

    /**
     * @param string $type
     * @return string
     */
    public static function getImageSourceFolder(string $type): string
    {
        $folder = '';
        if ($type === Image::SRC_SLIDES) {

            $folder = Image::SRC_SLIDES;

        } elseif ($type === Image::SRC_SLIDE_THUMBNAIL) {

            $folder = Image::SRC_SLIDE_THUMBNAIL;

        }

        return $folder;
    }
}
