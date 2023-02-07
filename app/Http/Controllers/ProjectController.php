<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Str;

/**
 * @group Project endpoints
 * @authenticated
 */
class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of project.
     *
     * @apiResourceCollection App\Http\Resources\ProjectResource
     * @apiResourceModel App\Models\Project
     * @throws AuthorizationException
     */
    public function index(ProjectService $projectService)
    {
        $user = Auth::user();
        $this->authorize('viewAny', Project::class);

        $projects = $projectService->getProjectsForUser($user, Project::query());

        return ProjectResource::collection($projects
            ->orderByDesc('updated_at')
            ->paginate(20)
        );
    }

    /**
     * Store a newly created project.
     *
     * @param ProjectRequest $request
     * @return ProjectResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\ProjectResource
     * @apiResourceModel App\Models\Project
     */
    public function store(ProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        $project = Project::create(
            [
                'user_id' => auth()->guard()->user()->id,
                'slug' => Str::slug($request->name),
                ...$request->only('name')
            ]
        );

        $project->user();
        return new ProjectResource($project->refresh());

    }

    /**
     * Display the specified project.
     *
     * @param Project $project
     * @return ProjectResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\ProjectResource
     * @apiResourceModel App\Models\Project
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        // Todo: return project with all child elements ( slide collections, slides, references, tracking codes and... )
        return new ProjectResource($project);
    }

    /**
     * Update the specified project.
     *
     * @param ProjectRequest $request
     * @param Project $project
     * @return ProjectResource
     * @throws AuthorizationException
     * @apiResource App\Http\Resources\ProjectResource
     * @apiResourceModel App\Models\Project
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update(
            [
                'slug' => Str::slug($request->name),
                ...$request->only('name')
            ]
        );

        return new ProjectResource($project->refresh());
    }

    /**
     * Remove the specified project.
     *
     * @param Project $project
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return response()->json([
            'error' => 0,
            'message' => 'Operation Successful',
        ], 204);
    }
}
