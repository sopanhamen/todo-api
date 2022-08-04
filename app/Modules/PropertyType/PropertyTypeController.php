<?php

namespace App\Modules\PropertyType;

use App\Http\Controllers\Controller;
use App\Modules\PropertyType\Exports\PropertyTypesExport;
use Illuminate\Http\Request;
use App\Modules\PropertyType\PropertyTypeService;
use App\Modules\PropertyType\Requests\CreatePropertyTypeRequest;
use App\Modules\PropertyType\Requests\UpdatePropertyTypeRequest;
use App\Modules\PropertyType\Resources\PropertyTypeResource;
use Maatwebsite\Excel\Facades\Excel;

class PropertyTypeController extends Controller
{
    protected $propertyTypeService;

    public function __construct(PropertyTypeService $propertyTypeService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->propertyTypeService = $propertyTypeService;
    }

    /**
     * @OA\GET(
     *     path="/api/property-types",
     *     tags={"Property Types"},
     *     summary="Get Property Types list",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $propertyType = $this->propertyTypeService->paginate($request->all());
        return PropertyTypeResource::collection($propertyType);
    }

    /**
     * @OA\GET(
     *     path="/api/property-types/{id}",
     *     tags={"Property Types"},
     *     summary="Get Property Types detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        $propertyType = $this->propertyTypeService->getOneOrFail($id, $request->all());
        return new PropertyTypeResource($propertyType);
    }

    /**
     * @OA\POST(
     *     path="/api/property-types",
     *     tags={"Property Types"},
     *     summary="Create a new Property Types",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreatePropertyTypeRequest $request)
    {
        $propertyType = $this->propertyTypeService->createOne($request->all());
        return new PropertyTypeResource($propertyType);
    }

    /**
     * @OA\PUT(
     *     path="/api/property-types/{id}",
     *     tags={"Property Types"},
     *     summary="Update an existing Property Types",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdatePropertyTypeRequest $request, int $id)
    {
        $propertyType = $this->propertyTypeService->updateOne($id, $request->all());
        return new PropertyTypeResource($propertyType);
    }

    /**
     * @OA\DELETE(
     *     path="/api/property-types/{id}",
     *     tags={"Property Types"},
     *     summary="Delete a Property Types",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $checking = $this->propertyTypeService->propertyTypeHaveProperties($id);
        if ($checking) {
            abort(422, 'This property type have properties!!');
        }

        $propertyType = $this->propertyTypeService->deleteOne($id);
        return new PropertyTypeResource($propertyType);
    }

    /**
     * @OA\GET(
     *     path="/api/property-types/trash",
     *     tags={"Property Types"},
     *     summary="Get property Types trashed list",
     *     description="Get property Types trashed List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', PropertyType::class);

        $propertyType = $this->propertyTypeService->paginateFromTrash($request->all());
        return PropertyTypeResource::collection($propertyType);
    }

    /**
     * @OA\POST(
     *     path="/api/property-types/{id}/restore",
     *     tags={"property Types"},
     *     summary="Restore a property Type",
     *     description="Restore a property Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', PropertyType::class);

        $propertyType = $this->propertyTypeService->restoreOne($id);
        return new PropertyTypeResource($propertyType);
    }

    /**
     * @OA\POST(
     *     path="/api/property-types/exports",
     *     tags={"Property Types"},
     *     summary="Export property-types to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        $this->authorize('export', PropertyType::class);

        return Excel::download(new PropertyTypesExport, 'property-types.xlsx');
    }
}
