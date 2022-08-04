<?php

namespace App\Modules\Province;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Province\Exports\ProvincesExport;
use App\Modules\Province\ProvinceService;
use App\Modules\Province\Resources\ProvinceResource;
use App\Modules\Province\Requests\CreateProvinceRequest;
use App\Modules\Province\Requests\UpdateProvinceRequest;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceController extends Controller
{
    protected $provinceService;

    public function __construct(ProvinceService $provinceService)
    {
        $this->middleware('auth')->except(['index', 'show']);
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
        $provinces = $this->provinceService->paginate($request->all());
        return ProvinceResource::collection($provinces);
    }

    /**
     * @OA\POST(
     *     path="/api/provinces",
     *     tags={"Provinces"},
     *     summary="Create a new Province",
     *     description="Create a new Province",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateProvinceRequest $request)
    {
        $provinces = $this->provinceService->createOne($request->all());
        return new ProvinceResource($provinces);
    }

    /**
     * @OA\GET(
     *     path="/api/provinces/{id}",
     *     tags={"Provinces"},
     *     summary="Get provinces detail",
     *     description="Get provinces detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $provinces = $this->provinceService->getOneOrFail($id, $request->all());
        return new ProvinceResource($provinces);
    }

    /**
     * @OA\PUT(
     *     path="/api/provinces/{id}",
     *     tags={"Provinces"},
     *     summary="Update an existing Province",
     *     description="Update an existing Province",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateProvinceRequest $request, string $id)
    {
        $provinces = $this->provinceService->updateOne($id, $request->all());
        return new ProvinceResource($provinces);
    }

    /**
     * @OA\DELETE(
     *     path="/api/provinces/{id}",
     *     tags={"Provinces"},
     *     summary="Delete a Province",
     *     description="Delete a Province",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $provinces = $this->provinceService->deleteOne($id);
        return new ProvinceResource($provinces);
    }

    /**
     * @OA\POST(
     *     path="/api/provinces/exports",
     *     tags={"Provinces"},
     *     summary="Export provinces to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        return Excel::download(new ProvincesExport, 'provinces.xlsx');
    }
}
