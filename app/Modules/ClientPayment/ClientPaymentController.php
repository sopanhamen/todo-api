<?php

namespace App\Modules\ClientPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\ClientPayment\PaymentDocument;
use App\Modules\ClientPayment\ClientPaymentService;
use App\Modules\ClientPayment\PaymentDocumentService;
use App\Modules\ClientPayment\Resources\ClientPaymentResource;
use App\Modules\ClientPayment\Resources\PaymentDocumentResource;
use App\Modules\ClientPayment\Requests\CreateClientPaymentRequest;
use App\Modules\ClientPayment\Requests\UpdateClientPaymentRequest;

class ClientPaymentController extends Controller
{
    protected $clientPaymentService;
    protected PaymentDocumentService $documentService;

    public function __construct(ClientPaymentService $clientPaymentService, PaymentDocumentService $documentService)
    {
        $this->middleware('auth');
        $this->documentService = $documentService;
        $this->clientPaymentService = $clientPaymentService;
    }

    /**
     * @OA\GET(
     *     path="/api/client-payments",
     *     tags={"Client Payments"},
     *     summary="Get Client Payments list",
     *     description="Get Client Payments List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientPayment::class);

        $clientPayments = $this->clientPaymentService->paginate($request->all());
        return ClientPaymentResource::collection($clientPayments);
    }

    /**
     * @OA\GET(
     *     path="/api/client-payments/{id}",
     *     tags={"Client Payments"},
     *     summary="Get Client Payment detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', ClientPayment::class);

        $clientPayment = $this->clientPaymentService->getOneOrFail($id, $request->all());
        return new ClientPaymentResource($clientPayment);
    }

    /**
     * @OA\POST(
     *     path="/api/client-payments",
     *     tags={"Client Payments"},
     *     summary="Create a new Client Payment",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateClientPaymentRequest $request)
    {
        $this->authorize('create', ClientPayment::class);

        $clientPayment = $this->clientPaymentService->createOne($request->all());
        return new ClientPaymentResource($clientPayment);
    }

    /**
     * @OA\PUT(
     *     path="/api/client-payments/{id}",
     *     tags={"Client Payments"},
     *     summary="Update an existing Client Payment",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateClientPaymentRequest $request, string $id)
    {
        $this->authorize('update', ClientPayment::class);

        $clientPayment = $this->clientPaymentService->updateOne($id, $request->all());
        return new ClientPaymentResource($clientPayment);
    }

    /**
     * @OA\DELETE(
     *     path="/api/client-payments/{id}",
     *     tags={"Client Payments"},
     *     summary="Delete a Client Payment",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', ClientPayment::class);

        $clientPayment = $this->clientPaymentService->deleteOne($id);
        return new ClientPaymentResource($clientPayment);
    }

    /**
     * @OA\POST(
     *     path="/api/client-payments/{id}/restore",
     *     tags={"Client Payments"},
     *     summary="Restore a Client Payment from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', ClientPayment::class);

        $clientPayment = $this->clientPaymentService->restoreOne($id);
        return new ClientPaymentResource($clientPayment);
    }

    /**
     * @OA\GET(
     *     path="/api/payments/{payment}/documents/{document}",
     *     tags={"Client Payments"},
     *     summary="download document",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function downloadDocument(string $paymentId, string $documentId)
    {
        $payment = $this->clientPaymentService->getOne($paymentId);
        $this->authorize('view', $payment);
        $document = $this->documentService->getOneOfPayment($documentId, $paymentId);

        if ($this->documentService->isImage($document->file_type)) {
            $this->documentService->getImageContent($document->file_path)->response();
        }

        return response()->download(
            $this->documentService->fullPath($document->file_path)
        );
    }

    /**
     * @OA\POST(
     *     path="/api/client-payments/{id}/upload-documents",
     *     tags={"Client Payments"},
     *     summary="Upload Payment Documents",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function uploadDocuments(string $id, Request $request)
    {
        $this->authorize('update', ClientPayment::class);

        $clientPayment = $this->clientPaymentService->saveDocuments($id, $request['documents']);
        return  $this->documentService->changeFormat($clientPayment);
    }


    /**
     * @OA\DELETE(
     *     path="/api/client-payments/{payment}/documents/{document}",
     *     tags={"Client Payments"},
     *     summary="Delete Payment document",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function deleteDocument(string $paymentId, string $documentId)
    {
        $this->authorize('delete', PaymentDocument::class);

        $paymentDocument = $this->documentService->deleteOne($documentId);
        return new PaymentDocumentResource($paymentDocument);
    }
}
