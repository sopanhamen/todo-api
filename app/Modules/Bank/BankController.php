<?php

namespace App\Modules\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Bank\BankService;
use App\Modules\Bank\Requests\CreateBankRequest;
use App\Modules\Bank\Requests\UpdateBankRequest;
use App\Modules\Bank\Resources\BankResource;

class BankController extends Controller
{
    protected $bankService;

    public function __construct(BankService $bankService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->bankService = $bankService;
    }

    /**
     * @OA\GET(
     *     path="/api/banks",
     *     tags={"Banks"},
     *     summary="Get Banks list",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $banks = $this->bankService->paginate($request->all());
        return BankResource::collection($banks);
    }

    /**
     * @OA\GET(
     *     path="/api/banks/{id}",
     *     tags={"Banks"},
     *     summary="Get Banks detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $banks = $this->bankService->getOneOrFail($id, $request->all());
        return new BankResource($banks);
    }

    /**
     * @OA\POST(
     *     path="/api/banks",
     *     tags={"Banks"},
     *     summary="Create a new Bank",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateBankRequest $request)
    {
        $bank = $this->bankService->createOne($request->all());
        return new BankResource($bank);
    }

    /**
     * @OA\PUT(
     *     path="/api/banks/{id}",
     *     tags={"Banks"},
     *     summary="Update an existing Bank",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateBankRequest $request, string $id)
    {
        $bank = $this->bankService->updateOne($id, $request->all());
        return new BankResource($bank);
    }

    /**
     * @OA\DELETE(
     *     path="/api/banks/{id}",
     *     tags={"Banks"},
     *     summary="Delete a Bank",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $bank = $this->bankService->deleteOne($id);
        return new BankResource($bank);
    }
}
