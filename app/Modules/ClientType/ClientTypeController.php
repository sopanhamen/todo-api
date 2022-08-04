<?php

namespace App\Modules\ClientType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ClientType\ClientTypeService;
use App\Modules\ClientType\Exports\ClientTypesExport;
use App\Modules\ClientType\Requests\CreateClientTypeRequest;
use App\Modules\ClientType\Requests\UpdateClientTypeRequest;
use App\Modules\ClientType\Resources\ClientTypeResource;
use Maatwebsite\Excel\Facades\Excel;

class ClientTypeController extends Controller
{
    protected $clientTypeService;

    public function __construct(ClientTypeService $clientTypeService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->clientTypeService = $clientTypeService;
    }

    /**
     * @OA\GET(
     *     path="/api/client-types",
     *     tags={"Client Types"},
     *     summary="Get Client Types list",
     *     description="Get Client Types List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $clientTypes = $this->clientTypeService->paginate($request->all());
        return ClientTypeResource::collection($clientTypes);
    }

    /**
     * @OA\GET(
     *     path="/api/client-types/trash",
     *     tags={"Client Types"},
     *     summary="Get Client Types list",
     *     description="Get Client Types List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', ClientType::class);

        $clientTypes = $this->clientTypeService->paginateFromTrash($request->all());
        return ClientTypeResource::collection($clientTypes);
    }

    /**
     * @OA\POST(
     *     path="/api/client-types",
     *     tags={"Client Types"},
     *     summary="Create a new Client Type",
     *     description="Create a new Client Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateClientTypeRequest $request)
    {
        $clientTypes = $this->clientTypeService->createOne($request->all());
        return new ClientTypeResource($clientTypes);
    }

    /**
     * @OA\GET(
     *     path="/api/client-types/{id}",
     *     tags={"Client Types"},
     *     summary="Get Client Types detail",
     *     description="Get Client Types detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $clientTypes = $this->clientTypeService->getOneOrFail($id, $request->all());
        return new ClientTypeResource($clientTypes);
    }

    /**
     * @OA\PUT(
     *     path="/api/client-types/{id}",
     *     tags={"Client Types"},
     *     summary="Update an existing Client Type",
     *     description="Update an existing Client Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateClientTypeRequest $request, $id)
    {
        $clientTypes = $this->clientTypeService->updateOne($id, $request->all());
        return new ClientTypeResource($clientTypes);
    }

    /**
     * @OA\DELETE(
     *     path="/api/client-types/{id}",
     *     tags={"Client Types"},
     *     summary="Delete a Client Type",
     *     description="Delete a Client Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $clientTypes = $this->clientTypeService->deleteOne($id);
        return new ClientTypeResource($clientTypes);
    }

    /**
     * @OA\DELETE(
     *     path="/api/client-types/{id}/restore",
     *     tags={"Client Types"},
     *     summary="Delete a Client Type",
     *     description="Delete a Client Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', ClientType::class);

        $clientTypes = $this->clientTypeService->restoreOne($id);
        return new ClientTypeResource($clientTypes);
    }

    /**
     * @OA\POST(
     *     path="/api/client-types/exports",
     *     tags={"Client Types"},
     *     summary="Export client-types to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        $this->authorize('export', ClientType::class);

        return Excel::download(new ClientTypesExport, 'client-types.xlsx');
    }
}
