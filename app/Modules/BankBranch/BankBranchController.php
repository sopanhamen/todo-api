<?php

namespace App\Modules\BankBranch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\BankBranch\BankBranchService;
use App\Modules\BankBranch\Requests\CreateBankBranchRequest;
use App\Modules\BankBranch\Requests\UpdateBankBranchRequest;
use App\Modules\BankBranch\Resources\BankBranchResource;

class BankBranchController extends Controller
{
    protected $bankBranchService;

    public function __construct(BankBranchService $bankBranchService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->bankBranchService = $bankBranchService;
    }

    /**
     * @OA\GET(
     *     path="/api/banks/branches",
     *     tags={"Bank Branches"},
     *     summary="Get Bank Branches list",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $bankBranches = $this->bankBranchService->paginate($request->all());
        return BankBranchResource::collection($bankBranches);
    }

    /**
     * @OA\GET(
     *     path="/api/banks/branches/{id}",
     *     tags={"Bank Branches"},
     *     summary="Get Bank Branch detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        $bankBranches = $this->bankBranchService->getOneOrFail($id, $request->all());
        return new BankBranchResource($bankBranches);
    }

    /**
     * @OA\POST(
     *     path="/api/banks/branches",
     *     tags={"Bank Branches"},
     *     summary="Create a new Branch",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateBankBranchRequest $request)
    {
        $bankBranch = $this->bankBranchService->createOne($request->all());
        return new BankBranchResource($bankBranch);
    }

    /**
     * @OA\PUT(
     *     path="/api/banks/branches/{id}",
     *     tags={"Bank Branches"},
     *     summary="Update an existing Bank Branch",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateBankBranchRequest $request, int $id)
    {
        $bankBranch = $this->bankBranchService->updateOne($id, $request->all());
        return new BankBranchResource($bankBranch);
    }

    /**
     * @OA\DELETE(
     *     path="/api/banks/branches/{id}",
     *     tags={"Bank Branches"},
     *     summary="Delete a Bank branch",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $bankBranch = $this->bankBranchService->deleteOne($id);
        return new BankBranchResource($bankBranch);
    }
}
