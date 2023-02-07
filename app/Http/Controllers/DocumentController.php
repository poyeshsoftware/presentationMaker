<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

/**
 * @group Documents endpoints
 * @authenticated
 */
class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     * @apiResourceCollection App\Http\Resources\DocumentResource
     * @apiResourceModel App\Models\Document
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $documents = Document::all();

        return DocumentResource::collection($documents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param DocumentRequest $request
     * @return DocumentResource|JsonResponse
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\DocumentResource
     * @apiResourceModel App\Models\Document
     */
    public function store(Project $project, DocumentRequest $request)
    {
        if ($project->id != $request->project_id) {
            return response()->json([
                'error' => "Project ID does not match !"
            ], 401);
        }
        $project = Project::find($request->project_id);

        $this->authorize('update', $project);

        if ($request->hasfile('file')) {
            $fileName = time() . '_'
                . md5($request->file('file')->getClientOriginalName())
                . "." . $request->file('file')->getClientOriginalExtension();

            $s3 = Storage::disk('local');

            $folder = "documents/" . $request->file('file')->getClientOriginalExtension();

            $filePath = "/" . $request->project_id . "/" . $folder . "/" . $fileName;

            $s3->put("/public/" . $filePath, file_get_contents($request->file), 'public');


            $document = Document::create([
                'project_id' => $request->project_id,
                "name" => $fileName,
                "format" => $request->file('file')->getClientOriginalExtension(),
            ]);

        } else {
            return response()->json([
                'error' => 'Error, no file to upload!'
            ], 401);
        }

        return new DocumentResource($document);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @param Document $document
     * @return DocumentResource|JsonResponse
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\DocumentResource
     * @apiResourceModel App\Models\Document
     */
    public function show(Project $project, Document $document)
    {
        if ($project->id != $document->project_id) {
            return response()->json([
                'error' => "Project ID does not match !"
            ], 401);
        }

        $this->authorize('view', $project);

        return new DocumentResource($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @param Document $document
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Project $project, Document $document)
    {
        if ($project->id != $document->project_id) {
            return response()->json([
                'error' => "Project ID does not match !"
            ], 401);
        }
        $this->authorize('update', $project);

        $document->delete();

        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful'
        ], 204);
    }
}
