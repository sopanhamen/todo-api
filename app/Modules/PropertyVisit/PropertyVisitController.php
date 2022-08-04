<?php

namespace App\Modules\PropertyVisit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\PropertyVisit\PropertyVisitService;
use App\Modules\PropertyVisit\Resources\PropertyVisitResource;
use App\Modules\PropertyVisit\Requests\CreatePropertyVisitRequest;
use App\Modules\PropertyVisit\Requests\UpdatePropertyVisitRequest;

class PropertyVisitController extends Controller
{
    protected $propertyVisitService;

    public function __construct(PropertyVisitService $propertyVisitService)
    {
        $this->middleware('auth');
        $this->propertyVisitService = $propertyVisitService;
    }

    /**
     * @OA\GET(
     *     path="/api/property-visits",
     *     tags={"Property Visits"},
     *     summary="Get Property Visits list",
     *     description="Get Property Visits List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', PropertyVisit::class);

        $propertyVisits = $this->propertyVisitService->paginate($request->all());
        return PropertyVisitResource::collection($propertyVisits);
    }

    /**
     * @OA\GET(
     *     path="/api/property-visits/{id}",
     *     tags={"Property Visits"},
     *     summary="Get Property Visit detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', PropertyVisit::class);

        $propertyVisit = $this->propertyVisitService->getOneOrFail($id, $request->all());
        return new PropertyVisitResource($propertyVisit);
    }

    /**
     * @OA\POST(
     *     path="/api/property-visits",
     *     tags={"Property Visits"},
     *     summary="Create a new Property Visit",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreatePropertyVisitRequest $request)
    {
        $this->authorize('create', PropertyVisit::class);

        $propertyVisit = $this->propertyVisitService->createOne($request->all());
        return new PropertyVisitResource($propertyVisit);
    }

    /**
     * @OA\PUT(
     *     path="/api/property-visits/{id}",
     *     tags={"Property Visits"},
     *     summary="Update an existing Property Visit",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdatePropertyVisitRequest $request, string $id)
    {
        $this->authorize('update', PropertyVisit::class);

        $propertyVisit = $this->propertyVisitService->updateOne($id, $request->all());
        return new PropertyVisitResource($propertyVisit);
    }

    /**
     * @OA\DELETE(
     *     path="/api/property-visits/{id}",
     *     tags={"Property Visits"},
     *     summary="Delete a Property Visit",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', PropertyVisit::class);

        $propertyVisit = $this->propertyVisitService->deleteOne($id);
        return new PropertyVisitResource($propertyVisit);
    }

    /**
     * @OA\POST(
     *     path="/api/property-visits/{id}/restore",
     *     tags={"Property Visits"},
     *     summary="Restore a Property Visit from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', PropertyVisit::class);

        $propertyVisit = $this->propertyVisitService->restoreOne($id);
        return new PropertyVisitResource($propertyVisit);
    }
}
