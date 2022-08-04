<?php

namespace App\Modules\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Project\Exports\ProjectsExport;
use App\Modules\Project\ProjectService;
use App\Modules\Project\Resources\ProjectResource;
use App\Modules\Project\Requests\CreateProjectRequest;
use App\Modules\Project\Requests\UpdateProjectRequest;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->middleware('auth');
        $this->projectService = $projectService;
    }

    /**
     * @OA\GET(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Get Projects list",
     *     description="Get Projects List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Project::class);

        $projects = $this->projectService->paginate($request->all());
        return ProjectResource::collection($projects);
    }

    /**
     * @OA\POST(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Create a new Project",
     *     description="Create a new Project",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        $projects = $this->projectService->createOne($request->all());
        return new ProjectResource($projects);
    }

    /**
     * @OA\GET(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Get projects detail",
     *     description="Get projects detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', Project::class);

        $projects = $this->projectService->getOneOrFail($id, $request->all());
        return new ProjectResource($projects);
    }

    /**
     * @OA\PUT(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Update an existing Project",
     *     description="Update an existing Project",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        $this->authorize('update', Project::class);

        $projects = $this->projectService->updateOne($id, $request->all());
        return new ProjectResource($projects);
    }

    /**
     * @OA\DELETE(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Delete a Project",
     *     description="Delete a Project",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Project::class);

        $projects = $this->projectService->deleteOne($id);
        return new ProjectResource($projects);
    }

    /**
     * @OA\GET(
     *     path="/api/projects/trash",
     *     tags={"Projects"},
     *     summary="Get project trashed list",
     *     description="Get project trashed List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', Project::class);

        $project = $this->projectService->paginateFromTrash($request->all());
        return ProjectResource::collection($project);
    }

    /**
     * @OA\POST(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Restore a Project from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', Project::class);

        $project = $this->projectService->restoreOne($id);
        return new ProjectResource($project);
    }

    /**
     * @OA\POST(
     *     path="/api/projects/exports",
     *     tags={"Projects"},
     *     summary="Export projects to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        $this->authorize('export', Project::class);

        return Excel::download(new ProjectsExport, 'projects.xlsx');
    }
}
