<?php

namespace App\Modules\CompanyBranch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\CompanyBranch\CompanyBranchService;
use App\Modules\CompanyBranch\Resources\CompanyBranchResource;
use App\Modules\CompanyBranch\Requests\CreateCompanyBranchRequest;
use App\Modules\CompanyBranch\Requests\UpdateCompanyBranchRequest;

class CompanyBranchController extends Controller
{
    protected $companyBranchService;

    public function __construct(CompanyBranchService $companyBranchService)
    {
        $this->middleware('auth')->except('index');
        $this->companyBranchService = $companyBranchService;
    }

    /**
     * @OA\GET(
     *     path="/api/company-branches",
     *     tags={"Company Branches"},
     *     summary="Get Company Branches list",
     *     description="Get Company Branches List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', CompanyBranch::class);

        $companyBranches = $this->companyBranchService->paginate($request->all());
        return CompanyBranchResource::collection($companyBranches);
    }

    /**
     * @OA\GET(
     *     path="/api/company-branches/{id}",
     *     tags={"Company Branches"},
     *     summary="Get Company Branch detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $companyBranch = $this->companyBranchService->getOneOrFail($id, $request->all());

        $this->authorize('view', $companyBranch);

        return new CompanyBranchResource($companyBranch);
    }

    /**
     * @OA\POST(
     *     path="/api/company-branches",
     *     tags={"Company Branches"},
     *     summary="Create a new Company Branch",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateCompanyBranchRequest $request)
    {
        $this->authorize('create', CompanyBranch::class);

        $companyBranch = $this->companyBranchService->createOne($request->all());
        return new CompanyBranchResource($companyBranch);
    }

    /**
     * @OA\PUT(
     *     path="/api/company-branches/{id}",
     *     tags={"Company Branches"},
     *     summary="Update an existing Company Branch",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateCompanyBranchRequest $request, string $id)
    {
        $this->authorize('update', CompanyBranch::class);

        $companyBranch = $this->companyBranchService->updateOne($id, $request->all());
        return new CompanyBranchResource($companyBranch);
    }

    /**
     * @OA\DELETE(
     *     path="/api/company-branches/{id}",
     *     tags={"Company Branches"},
     *     summary="Delete a Company Branch",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', CompanyBranch::class);

        $companyBranch = $this->companyBranchService->deleteOne($id);
        return new CompanyBranchResource($companyBranch);
    }

    /**
     * @OA\POST(
     *     path="/api/company-branches/{id}/restore",
     *     tags={"Company Branches"},
     *     summary="Restore a Company Branch from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function trash(Request $request)
    {
        $this->authorize('delete', CompanyBranch::class);

        $companyBranches = $this->companyBranchService->paginateFromTrash($request->all());
        return CompanyBranchResource::collection($companyBranches);
    }

    public function restore(string $id)
    {
        $this->authorize('restore', CompanyBranch::class);

        $companyBranch = $this->companyBranchService->restoreOne($id);
        return new CompanyBranchResource($companyBranch);
    }
}