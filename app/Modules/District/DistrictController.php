<?php

namespace App\Modules\District;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\District\DistrictService;
use App\Modules\District\Exports\DistrictsExport;
use App\Modules\District\Resources\DistrictResource;
use App\Modules\District\Requests\CreateDistrictRequest;
use App\Modules\District\Requests\UpdateDistrictRequest;
use Maatwebsite\Excel\Facades\Excel;

class DistrictController extends Controller
{
    protected $districtService;

    public function __construct(DistrictService $districtService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->districtService = $districtService;
    }

    /**
     * @OA\GET(
     *     path="/api/districts",
     *     tags={"Districts"},
     *     summary="Get Districts list",
     *     description="Get Districts List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function index(Request $request)
    {
        $districts = $this->districtService->paginate($request->all());
        return DistrictResource::collection($districts);
    }

    /**
     * @OA\POST(
     *     path="/api/districts",
     *     tags={"Districts"},
     *     summary="Create a new District",
     *     description="Create a new District",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateDistrictRequest $request)
    {
        $districts = $this->districtService->createOne($request->all());
        return new DistrictResource($districts);
    }

    /**
     * @OA\GET(
     *     path="/api/districts/{id}",
     *     tags={"Districts"},
     *     summary="Get districts detail",
     *     description="Get districts detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $districts = $this->districtService->getOneOrFail($id, $request->all());
        return new DistrictResource($districts);
    }

    /**
     * @OA\PUT(
     *     path="/api/districts/{id}",
     *     tags={"Districts"},
     *     summary="Update an existing District",
     *     description="Update an existing District",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateDistrictRequest $request, string $id)
    {
        $districts = $this->districtService->updateOne($id, $request->all());
        return new DistrictResource($districts);
    }

    /**
     * @OA\DELETE(
     *     path="/api/districts/{id}",
     *     tags={"Districts"},
     *     summary="Delete a District",
     *     description="Delete a District",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $districts = $this->districtService->deleteOne($id);
        return new DistrictResource($districts);
    }

    /**
     * @OA\POST(
     *     path="/api/districts/exports",
     *     tags={"Districts"},
     *     summary="Export districts to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        return Excel::download(new DistrictsExport, 'districts.xlsx');
    }
}
