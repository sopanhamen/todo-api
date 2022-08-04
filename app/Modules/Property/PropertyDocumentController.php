<?php

namespace App\Modules\Property;

use App\Http\Controllers\Controller;
use App\Modules\Property\Resources\PropertyDocumentResource;
use Illuminate\Http\Request;

class PropertyDocumentController extends Controller
{
    protected PropertyDocumentService $documentService;
    private PropertyService $propertyService;

    public function __construct(PropertyDocumentService $documentService, PropertyService $propertyService)
    {
        $this->middleware('auth');
        $this->documentService = $documentService;
        $this->propertyService = $propertyService;
    }

    /**
     * @OA\GET(
     *     path="/api/properties/{property}/documents",
     *     tags={"Property Documents"},
     *     summary="Get Properties document list",
     *     description="Get Properties Document List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(string $propertyId)
    {
        $documents = $this->documentService->getAll($propertyId);
        return PropertyDocumentResource::collection($documents);
    }

    /**
     * @OA\GET(
     *     path="/api/properties/{property}/documents/{document}",
     *     tags={"Property Documents"},
     *     summary="View or download document",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(string $propertyId, string $documentId)
    {
        $property = $this->propertyService->getOne($propertyId);

        $this->authorize('view', $property);

        $document = $this->documentService->getOneOfProperty($documentId, $propertyId);

        if ($this->documentService->isImage($document->file_type)) {
            return response($this->documentService->getImageContent($document->file_path));
        }

        return response($this->documentService->fullPath($document->file_path));
    }

    /**
     * @OA\GET(
     *     path="/api/properties/sample-excel",
     *     tags={"Sample Excel"},
     *     summary="download excel sample",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function exportSampleExcel()
    {
        return response()->download(
            $this->documentService->fullPathDocument('sample/sample-import.xlsx')
        );
    }
}