<?php

namespace App\Modules\Developer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Developer\DeveloperService;
use App\Modules\Developer\Exports\DevelopersExport;
use App\Modules\Developer\Resources\DeveloperResource;
use App\Modules\Developer\Requests\CreateDeveloperRequest;
use App\Modules\Developer\Requests\UpdateDeveloperRequest;
use Maatwebsite\Excel\Facades\Excel;

class DeveloperController extends Controller
{
    protected $developerService;

    public function __construct(DeveloperService $developerService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->developerService = $developerService;
    }

    /**
     * @OA\GET(
     *     path="/api/developers",
     *     tags={"Developers"},
     *     summary="Get Developers list",
     *     description="Get Developers List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $developers = $this->developerService->paginate($request->all());
        return DeveloperResource::collection($developers);
    }

    /**
     * @OA\GET(
     *     path="/api/developers/{id}",
     *     tags={"Developers"},
     *     summary="Get developer by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $developers = $this->developerService->getOneOrFail($id, $request->all());
        return new DeveloperResource($developers);
    }

    /**
     * @OA\POST(
     *     path="/api/developers",
     *     tags={"Developers"},
     *     summary="Create a new Developer",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateDeveloperRequest $request)
    {
        $developers = $this->developerService->createOne($request->all());
        return new DeveloperResource($developers);
    }

    /**
     * @OA\PUT(
     *     path="/api/developers/{id}",
     *     tags={"Developers"},
     *     summary="Update an existing Developer",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateDeveloperRequest $request, int $id)
    {
        $developers = $this->developerService->updateOne($id, $request->all());
        return new DeveloperResource($developers);
    }

    /**
     * @OA\DELETE(
     *     path="/api/developers/{id}",
     *     tags={"Developers"},
     *     summary="Delete a Developer",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $developers = $this->developerService->deleteOne($id);
        return new DeveloperResource($developers);
    }

    /**
     * @OA\GET(
     *     path="/api/developers/trash",
     *     tags={"Developers"},
     *     summary="Get developers trashed list",
     *     description="Get developers trashed List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', Developer::class);

        $developer = $this->developerService->paginateFromTrash($request->all());
        return DeveloperResource::collection($developer);
    }

    /**
     * @OA\POST(
     *     path="/api/developers/{id}/restore",
     *     tags={"developers"},
     *     summary="Restore a developer",
     *     description="Restore a developer",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', Developer::class);

        $developer = $this->developerService->restoreOne($id);
        return new DeveloperResource($developer);
    }

    /**
     * @OA\POST(
     *     path="/api/developers/exports",
     *     tags={"Developers"},
     *     summary="Export developers to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        $this->authorize('export', Developer::class);

        return Excel::download(new DevelopersExport, 'developers.xlsx');
    }
}
