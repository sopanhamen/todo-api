<?php

namespace App\Modules\PropertyHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\PropertyHistory\PropertyHistoryService;
use App\Modules\PropertyHistory\Resources\PropertyHistoryResource;
use App\Modules\PropertyHistory\Requests\CreatePropertyHistoryRequest;
use App\Modules\PropertyHistory\Requests\UpdatePropertyHistoryRequest;

class PropertyHistoryController extends Controller
{
    protected $propertyHistoryService;

    public function __construct(PropertyHistoryService $propertyHistoryService)
    {
        $this->middleware('auth');
        $this->propertyHistoryService = $propertyHistoryService;
    }

    /**
     * @OA\GET(
     *     path="/api/property-histories",
     *     tags={"Property Histories"},
     *     summary="Get Property Histories list",
     *     description="Get Property Histories List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', PropertyHistory::class);

        $propertyHistories = $this->propertyHistoryService->paginate($request->all());
        return PropertyHistoryResource::collection($propertyHistories);
    }

    /**
     * @OA\GET(
     *     path="/api/property-histories/{id}",
     *     tags={"Property Histories"},
     *     summary="Get Property History detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        $this->authorize('view', PropertyHistory::class);

        $propertyHistory = $this->propertyHistoryService->getOneOrFail($id, $request->all());
        return new PropertyHistoryResource($propertyHistory);
    }

    /**
     * @OA\POST(
     *     path="/api/property-histories",
     *     tags={"Property Histories"},
     *     summary="Create a new Property History",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreatePropertyHistoryRequest $request)
    {
        $this->authorize('create', PropertyHistory::class);

        $propertyHistory = $this->propertyHistoryService->createOne($request->all());
        return new PropertyHistoryResource($propertyHistory);
    }

    /**
     * @OA\PUT(
     *     path="/api/property-histories/{id}",
     *     tags={"Property Histories"},
     *     summary="Update an existing Property History",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdatePropertyHistoryRequest $request, int $id)
    {
        $this->authorize('update', PropertyHistory::class);

        $propertyHistory = $this->propertyHistoryService->updateOne($id, $request->all());
        return new PropertyHistoryResource($propertyHistory);
    }

    /**
     * @OA\DELETE(
     *     path="/api/property-histories/{id}",
     *     tags={"Property Histories"},
     *     summary="Delete a Property History",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        $this->authorize('delete', PropertyHistory::class);

        $propertyHistory = $this->propertyHistoryService->deleteOne($id);
        return new PropertyHistoryResource($propertyHistory);
    }

    /**
     * @OA\POST(
     *     path="/api/property-histories/{id}/restore",
     *     tags={"Property Histories"},
     *     summary="Restore a Property History from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        $this->authorize('restore', PropertyHistory::class);

        $propertyHistory = $this->propertyHistoryService->restoreOne($id);
        return new PropertyHistoryResource($propertyHistory);
    }
}
