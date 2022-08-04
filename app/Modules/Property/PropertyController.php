<?php

namespace App\Modules\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Property\PropertyService;
use App\Modules\Property\Requests\CreateMultiplePropertiesRequest;
use App\Modules\Property\Resources\PropertyResource;
use App\Modules\Property\Requests\CreatePropertyRequest;
use App\Modules\Property\Requests\TransferPropertyRequest;
use App\Modules\Property\Requests\UpdatePropertyRequest;
use App\Modules\Property\Resources\PropertyContactResource;
use App\Modules\Property\Resources\PropertyListingResource;
use App\Modules\Property\Resources\PropertyMapResource;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->middleware('auth');
        $this->propertyService = $propertyService;
    }

    /**
     * @OA\GET(
     *     path="/api/properties",
     *     tags={"Properties"},
     *     summary="Get Properties list",
     *     description="Get Properties List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Property::class);

        $properties = $this->propertyService->paginate($request->all());
        return PropertyListingResource::collection($properties);
    }

    /**
     * @OA\GET(
     *     path="/api/properties/maps",
     *     tags={"Properties"},
     *     summary="Get Properties map list",
     *     description="Get Properties map list as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function maps(Request $request)
    {
        $this->authorize('viewAny', Property::class);

        $propertyMaps = $this->propertyService->paginateMaps($request->all());
        return PropertyMapResource::collection($propertyMaps);
    }

    /**
     * @OA\GET(
     *     path="/api/properties/{id}",
     *     tags={"Properties"},
     *     summary="Get Property detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(string $id)
    {
        $property = $this->propertyService->getOneOrFail($id);

        $this->authorize('view', $property);

        return new PropertyResource($property);
    }

    /**
     * @OA\POST(
     *     path="/api/properties",
     *     tags={"Properties"},
     *     summary="Create a new Property",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreatePropertyRequest $request)
    {
        $this->authorize('create', Property::class);

        $property = $this->propertyService->createOne($request->all());
        return new PropertyResource($property);
    }

    /**
     * @OA\POST(
     *     path="/api/properties/create-many",
     *     tags={"Properties"},
     *     summary="Create a new Property",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function storeMany(CreateMultiplePropertiesRequest $request)
    {
        $this->authorize('create', Property::class);

        return $this->propertyService->createMany($request->input('properties'));
    }

    /**
     * @OA\PUT(
     *     path="/api/properties/{id}",
     *     tags={"Properties"},
     *     summary="Update an existing Property",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdatePropertyRequest $request, string $id)
    {
        $this->authorize('update', Property::class);

        $property = $this->propertyService->updateOne($id, $request->all());
        return new PropertyResource($property);
    }

    /**
     * @OA\DELETE(
     *     path="/api/properties/{id}",
     *     tags={"Properties"},
     *     summary="Delete a Property",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Property::class);

        $property = $this->propertyService->deleteOne($id);
        return new PropertyResource($property);
    }

    /**
     * @OA\GET(
     *     path="/api/properties/trash",
     *     tags={"Properties"},
     *     summary="Get properties trashed list",
     *     description="Get properties trashed List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function trash(Request $request)
    {
        $this->authorize('delete', Property::class);

        $property = $this->propertyService->paginateFromTrash($request->all());
        return PropertyResource::collection($property);
    }

    /**
     * @OA\POST(
     *     path="/api/properties/{id}/restore",
     *     tags={"Properties"},
     *     summary="Restore a Property from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', Property::class);

        $property = $this->propertyService->restoreOne($id);
        return new PropertyResource($property);
    }

    /**
     * @OA\DELETE(
     *     path="/api/properties/{propertyId}/image/{imageId}",
     *     tags={"Properties"},
     *     summary="Delete a Property image",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteImage(string $propertyId, string $imageId)
    {
        $this->authorize('update', Property::class);

        return $this->propertyService->deleteImage($propertyId, $imageId);
    }

    /**
     * @OA\DELETE(
     *     path="/api/properties/{propertyId}/document/{documentId}",
     *     tags={"Properties"},
     *     summary="Delete a Property document",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteDocument(string $propertyId, string $documentId)
    {
        $this->authorize('update', Property::class);

        return $this->propertyService->deleteDocument($propertyId, $documentId);
    }

    /**
     * @OA\DELETE(
     *     path="/api/properties/{propertyId}/contacts",
     *     tags={"Properties"},
     *     summary="Get list of contacts of a property",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getContacts(string $propertyId)
    {
        return new PropertyContactResource($this->propertyService->getContacts($propertyId));
    }

    /**
     * @OA\POST(
     *     path="/api/properties/{id}/approve",
     *     tags={"Properties"},
     *     summary="Approve property registration",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function approve(string $id)
    {
        $property = $this->propertyService->getOneOrFail($id);

        $this->authorize('approve', $property);

        $property = $this->propertyService->approve($property);
        return new PropertyResource($property);
    }

    /**
     * @OA\DELETE(
     *     path="/api/properties/transfer",
     *     tags={"Properties"},
     *     summary="Get list of transfer of a property",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function transfer(TransferPropertyRequest $request)
    {
        $this->authorize('transfer', Property::class);

        $properties = $this->propertyService->transfer(
            $request->transfer_from,
            $request->transfer_to,
            $request->properties
        );

        return PropertyListingResource::collection($properties);
    }

    /**
     * @OA\POST(
     *     path="/api/properties/{id}/publish",
     *     tags={"Properties"},
     *     summary="Publish property registration",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function publish(string $id)
    {
        $property = $this->propertyService->getOneOrFail($id);

        $this->authorize('publish', $property);

        $property = $this->propertyService->publish($property);
        return new PropertyResource($property);
    }
}
