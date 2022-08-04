<?php

namespace App\Modules\Facility;

use App\Http\Controllers\Controller;
use App\Modules\Facility\Exports\FacilitiesExport;
use Illuminate\Http\Request;
use App\Modules\Facility\FacilityService;
use App\Modules\Facility\Resources\FacilityResource;
use App\Modules\Facility\Requests\CreateFacilityRequest;
use App\Modules\Facility\Requests\UpdateFacilityRequest;
use Maatwebsite\Excel\Facades\Excel;

class FacilityController extends Controller
{
    protected $facilityService;

    public function __construct(FacilityService $facilityService)
    {
        $this->middleware('auth');
        $this->facilityService = $facilityService;
    }

    /**
     * @OA\GET(
     *     path="/api/facilities",
     *     tags={"Facilities"},
     *     summary="Get Facilities list",
     *     description="Get Facilities List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Facility::class);

        $facilities = $this->facilityService->paginate($request->all());
        return FacilityResource::collection($facilities);
    }

    /**
     * @OA\GET(
     *     path="/api/facilities/{id}",
     *     tags={"Facilities"},
     *     summary="Get Facility detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        $this->authorize('view', Facility::class);

        $facility = $this->facilityService->getOneOrFail($id, $request->all());
        return new FacilityResource($facility);
    }

    /**
     * @OA\POST(
     *     path="/api/facilities",
     *     tags={"Facilities"},
     *     summary="Create a new Facility",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateFacilityRequest $request)
    {
        $this->authorize('create', Facility::class);

        $facility = $this->facilityService->createOne($request->all());
        return new FacilityResource($facility);
    }

    /**
     * @OA\PUT(
     *     path="/api/facilities/{id}",
     *     tags={"Facilities"},
     *     summary="Update an existing Facility",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateFacilityRequest $request, int $id)
    {
        $this->authorize('update', Facility::class);

        $facility = $this->facilityService->updateOne($id, $request->all());
        return new FacilityResource($facility);
    }

    /**
     * @OA\DELETE(
     *     path="/api/facilities/{id}",
     *     tags={"Facilities"},
     *     summary="Delete a Facility",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $this->authorize('delete', Facility::class);

        $facility = $this->facilityService->getOneOrFail($id, ['counts' => 'propertyTypes']);

        if ($facility->property_types_count > 0) {
            abort(403);
        }

        $this->facilityService->deleteModel($facility);

        return new FacilityResource($facility);
    }

    /**
     * @OA\GET(
     *     path="/api/facilities/trash",
     *     tags={"Facilities"},
     *     summary="Get facilities trashed list",
     *     description="Get facilities trashed List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', Facility::class);

        $facility = $this->facilityService->paginateFromTrash($request->all());
        return FacilityResource::collection($facility);
    }

    /**
     * @OA\POST(
     *     path="/api/facilities/{id}/restore",
     *     tags={"Facilities"},
     *     summary="Restore a Facility from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        $this->authorize('restore', Facility::class);

        $facility = $this->facilityService->restoreOne($id);
        return new FacilityResource($facility);
    }

    /**
     * @OA\POST(
     *     path="/api/facilities/exports",
     *     tags={"Facilities"},
     *     summary="Export facilities to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        $this->authorize('export', Facility::class);

        return Excel::download(new FacilitiesExport, 'facilities.xlsx');
    }
}
