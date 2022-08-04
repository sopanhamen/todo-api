<?php

namespace App\Modules\ClientRequirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ClientRequirement\ClientRequirementService;
use App\Modules\ClientRequirement\Resources\ClientRequirementResource;
use App\Modules\ClientRequirement\Requests\CreateClientRequirementRequest;
use App\Modules\ClientRequirement\Requests\UpdateClientRequirementRequest;

class ClientRequirementController extends Controller
{
    protected $service;

    public function __construct(ClientRequirementService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
     * @OA\GET(
     *     path="/api/client-requirements",
     *     tags={"Client Requirements"},
     *     summary="Get Client Requirements list",
     *     description="Get Client Requirements List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientRequirement::class);

        $clientRequirements = $this->service->paginate($request->all());
        return ClientRequirementResource::collection($clientRequirements);
    }

    /**
     * @OA\GET(
     *     path="/api/client-requirements/{id}",
     *     tags={"Client Requirements"},
     *     summary="Get Client Requirement detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', ClientRequirement::class);

        $clientRequirement = $this->service->getOneOrFail($id, $request->all());
        return new ClientRequirementResource($clientRequirement);
    }

    /**
     * @OA\POST(
     *     path="/api/client-requirements",
     *     tags={"Client Requirements"},
     *     summary="Create a new Client Requirement",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateClientRequirementRequest $request)
    {
        $this->authorize('create', ClientRequirement::class);

        $clientRequirement = $this->service->createOne($request->all());
        return new ClientRequirementResource($clientRequirement);
    }

    /**
     * @OA\PUT(
     *     path="/api/client-requirements/{id}",
     *     tags={"Client Requirements"},
     *     summary="Update an existing Client Requirement",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateClientRequirementRequest $request, string $id)
    {
        $this->authorize('update', ClientRequirement::class);

        $clientRequirement = $this->service->updateOne($id, $request->except('client_id'));
        return new ClientRequirementResource($clientRequirement);
    }

    /**
     * @OA\DELETE(
     *     path="/api/client-requirements/{id}",
     *     tags={"Client Requirements"},
     *     summary="Delete a Client Requirement",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', ClientRequirement::class);

        $clientRequirement = $this->service->deleteOne($id);
        return new ClientRequirementResource($clientRequirement);
    }

    /**
     * @OA\POST(
     *     path="/api/client-requirements/{id}/restore",
     *     tags={"Client Requirements"},
     *     summary="Restore a Client Requirement from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', ClientRequirement::class);

        $clientRequirement = $this->service->restoreOne($id);
        return new ClientRequirementResource($clientRequirement);
    }

    /**
     * @OA\POST(
     *     path="/api/client-requirements/{id}/complete",
     *     tags={"Client Requirements"},
     *     summary="Complete a Client Requirement",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function complete(string $id)
    {
        $this->authorize('create', ClientRequirement::class);

        $clientRequirement = $this->service->complete($id);
        return new ClientRequirementResource($clientRequirement);
    }

    /**
     * @OA\POST(
     *     path="/api/client-requirements/{id}/cancel",
     *     tags={"Client Requirements"},
     *     summary="Complete a Client Requirement",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function cancel(string $id)
    {
        $this->authorize('create', ClientRequirement::class);

        $clientRequirement = $this->service->cancel($id);
        return new ClientRequirementResource($clientRequirement);
    }
}
