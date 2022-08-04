<?php

namespace App\Modules\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Company\CompanyService;
use App\Modules\Company\Resources\CompanyResource;
use App\Modules\Company\Requests\CreateCompanyRequest;
use App\Modules\Company\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->companyService = $companyService;
    }

    /**
     * @OA\GET(
     *     path="/api/companies",
     *     tags={"Companies"},
     *     summary="Get Companies list",
     *     description="Get Companies List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $companies = $this->companyService->paginate($request->all());
        return CompanyResource::collection($companies);
    }

    /**
     * @OA\POST(
     *     path="/api/companies",
     *     tags={"Companies"},
     *     summary="Create a new Company",
     *     description="Create a new Company",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateCompanyRequest $request)
    {
        $companies = $this->companyService->createOne($request->all());
        return new CompanyResource($companies);
    }

    /**
     * @OA\GET(
     *     path="/api/companies/{id}",
     *     tags={"Companies"},
     *     summary="Get companies detail",
     *     description="Get companies detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $companies = $this->companyService->getOneOrFail($id, $request->all());
        return new CompanyResource($companies);
    }

    /**
     * @OA\PUT(
     *     path="/api/companies/{id}",
     *     tags={"Companies"},
     *     summary="Update an existing Company",
     *     description="Update an existing Company",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateCompanyRequest $request, string $id)
    {
        $companies = $this->companyService->updateOne($id, $request->all());
        return new CompanyResource($companies);
    }

    /**
     * @OA\DELETE(
     *     path="/api/companies/{id}",
     *     tags={"Companies"},
     *     summary="Delete a Company",
     *     description="Delete a Company",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $companies = $this->companyService->deleteOne($id);
        return new CompanyResource($companies);
    }
}
