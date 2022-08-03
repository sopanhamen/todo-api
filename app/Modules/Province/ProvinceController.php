<?php

namespace App\Modules\Province;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Province\ProvinceService;
use App\Modules\Province\Resources\ProvinceResource;
use App\Modules\Province\Requests\CreateProvinceRequest;
use App\Modules\Province\Requests\UpdateProvinceRequest;

class ProvinceController extends Controller
{
    protected $provinceService;

    public function __construct(ProvinceService $provinceService)
    {
        // $this->middleware('auth');
        $this->provinceService = $provinceService;
    }

    /**
     * @OA\GET(
     *     path="/api/provinces",
     *     tags={"Provinces"},
     *     summary="Get Provinces list",
     *     description="Get Provinces List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', Province::class);

        $provinces = $this->provinceService->paginate($request->all());
        return ProvinceResource::collection($provinces);
    }

    /**
     * @OA\GET(
     *     path="/api/provinces/{id}",
     *     tags={"Provinces"},
     *     summary="Get Province detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        // $this->authorize('view', Province::class);

        $province = $this->provinceService->getOneOrFail($id, $request->all());
        return new ProvinceResource($province);
    }

    /**
     * @OA\POST(
     *     path="/api/provinces",
     *     tags={"Provinces"},
     *     summary="Create a new Province",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateProvinceRequest $request)
    {
        // $this->authorize('create', Province::class);

        $province = $this->provinceService->createOne($request->all());
        return new ProvinceResource($province);
    }

    /**
     * @OA\PUT(
     *     path="/api/provinces/{id}",
     *     tags={"Provinces"},
     *     summary="Update an existing Province",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateProvinceRequest $request, int $id)
    {
        $this->authorize('update', Province::class);

        $province = $this->provinceService->updateOne($id, $request->all());
        return new ProvinceResource($province);
    }

    /**
     * @OA\DELETE(
     *     path="/api/provinces/{id}",
     *     tags={"Provinces"},
     *     summary="Delete a Province",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        // $this->authorize('delete', Province::class);

        $province = $this->provinceService->deleteOne($id);
        return new ProvinceResource($province);
    }

    /**
     * @OA\POST(
     *     path="/api/provinces/{id}/restore",
     *     tags={"Provinces"},
     *     summary="Restore a Province from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        // $this->authorize('restore', Province::class);

        $province = $this->provinceService->restoreOne($id);
        return new ProvinceResource($province);
    }
}
