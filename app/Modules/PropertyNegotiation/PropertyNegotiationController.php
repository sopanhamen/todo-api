<?php

namespace App\Modules\PropertyNegotiation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\PropertyNegotiation\PropertyNegotiationService;
use App\Modules\PropertyNegotiation\Resources\PropertyNegotiationResource;
use App\Modules\PropertyNegotiation\Requests\CreatePropertyNegotiationRequest;
use App\Modules\PropertyNegotiation\Requests\UpdatePropertyNegotiationRequest;

class PropertyNegotiationController extends Controller
{
    protected $propertyNegotiationService;

    public function __construct(PropertyNegotiationService $propertyNegotiationService)
    {
        $this->middleware('auth');
        $this->propertyNegotiationService = $propertyNegotiationService;
    }

    /**
     * @OA\GET(
     *     path="/api/property-negotiations",
     *     tags={"Property Negotiations"},
     *     summary="Get Property Negotiations list",
     *     description="Get Property Negotiations List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', PropertyNegotiation::class);

        $propertyNegotiations = $this->propertyNegotiationService->paginate($request->all());
        return PropertyNegotiationResource::collection($propertyNegotiations);
    }

    /**
     * @OA\GET(
     *     path="/api/property-negotiations/{id}",
     *     tags={"Property Negotiations"},
     *     summary="Get Property Negotiation detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', PropertyNegotiation::class);

        $propertyNegotiation = $this->propertyNegotiationService->getOneOrFail($id, $request->all());
        return new PropertyNegotiationResource($propertyNegotiation);
    }

    /**
     * @OA\POST(
     *     path="/api/property-negotiations",
     *     tags={"Property Negotiations"},
     *     summary="Create a new Property Negotiation",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreatePropertyNegotiationRequest $request)
    {
        $this->authorize('create', PropertyNegotiation::class);

        $propertyNegotiation = $this->propertyNegotiationService->createOne($request->all());
        return new PropertyNegotiationResource($propertyNegotiation);
    }

    /**
     * @OA\PUT(
     *     path="/api/property-negotiations/{id}",
     *     tags={"Property Negotiations"},
     *     summary="Update an existing Property Negotiation",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdatePropertyNegotiationRequest $request, string $id)
    {
        $this->authorize('update', PropertyNegotiation::class);

        $propertyNegotiation = $this->propertyNegotiationService->updateOne($id, $request->all());
        return new PropertyNegotiationResource($propertyNegotiation);
    }

    /**
     * @OA\DELETE(
     *     path="/api/property-negotiations/{id}",
     *     tags={"Property Negotiations"},
     *     summary="Delete a Property Negotiation",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', PropertyNegotiation::class);

        $propertyNegotiation = $this->propertyNegotiationService->deleteOne($id);
        return new PropertyNegotiationResource($propertyNegotiation);
    }

    /**
     * @OA\POST(
     *     path="/api/property-negotiations/{id}/restore",
     *     tags={"Property Negotiations"},
     *     summary="Restore a Property Negotiation from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', PropertyNegotiation::class);

        $propertyNegotiation = $this->propertyNegotiationService->restoreOne($id);
        return new PropertyNegotiationResource($propertyNegotiation);
    }
}
