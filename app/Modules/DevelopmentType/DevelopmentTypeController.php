<?php

namespace App\Modules\DevelopmentType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\DevelopmentType\DevelopmentTypeService;
use App\Modules\DevelopmentType\Exports\DevelopmentTypesExport;
use App\Modules\DevelopmentType\Resources\DevelopmentTypeResource;
use App\Modules\DevelopmentType\Requests\CreateDevelopmentTypeRequest;
use App\Modules\DevelopmentType\Requests\UpdateDevelopmentTypeRequest;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DevelopmentTypeController extends Controller
{
    protected $developmentTypeService;

    public function __construct(DevelopmentTypeService $developmentTypeService)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->developmentTypeService = $developmentTypeService;
    }

    /**
     * @OA\GET(
     *     path="/api/development-types",
     *     tags={"Development Types"},
     *     summary="Get DevelopmentTypes list",
     *     description="Get DevelopmentTypes List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $developmentTypes = $this->developmentTypeService->paginate($request->all());
        return DevelopmentTypeResource::collection($developmentTypes);
    }
    /**
     * @OA\GET(
     *     path="/api/development-types{id}",
     *     tags={"Development Types"},
     *     summary="Get Development Types by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        $developmentType = $this->developmentTypeService->getOneOrFail($id, $request->all());
        return new DevelopmentTypeResource($developmentType);
    }

    /**
     * @OA\POST(
     *     path="/api/development-types",
     *     tags={"Development Types"},
     *     summary="Create a new Development Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateDevelopmentTypeRequest $request)
    {
        $developmentType = $this->developmentTypeService->createOne($request->all());
        return new DevelopmentTypeResource($developmentType);
    }

    /**
     * @OA\PUT(
     *     path="/api/development-types/{id}",
     *     tags={"Development Types"},
     *     summary="Update an existing Development Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateDevelopmentTypeRequest $request, int $id)
    {
        $developmentType = $this->developmentTypeService->updateOne($id, $request->all());
        return new DevelopmentTypeResource($developmentType);
    }

    /**
     * @OA\DELETE(
     *     path="/api/development-types/{id}",
     *     tags={"Development Types"},
     *     summary="Delete a Development Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $developmentType = $this->developmentTypeService->deleteOne($id);
        return new DevelopmentTypeResource($developmentType);
    }

    /**
     * @OA\GET(
     *     path="/api/development-types/trash",
     *     tags={"Development Types"},
     *     summary="Get development Types trashed list",
     *     description="Get development Types trashed List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', DevelopmentType::class);

        $developmentType = $this->developmentTypeService->paginateFromTrash($request->all());
        return DevelopmentTypeResource::collection($developmentType);
    }

    /**
     * @OA\POST(
     *     path="/api/development-types/{id}/restore",
     *     tags={"development Types"},
     *     summary="Restore a development Type",
     *     description="Restore a development Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', DevelopmentType::class);

        $developmentType = $this->developmentTypeService->restoreOne($id);
        return new DevelopmentTypeResource($developmentType);
    }

    /**
     * @OA\POST(
     *     path="/api/development-types/exports",
     *     tags={"Development Types"},
     *     summary="Export development-types to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        $this->authorize('export', DevelopmentType::class);

        return Excel::download(new DevelopmentTypesExport, 'development-types.xlsx');
    }
}
