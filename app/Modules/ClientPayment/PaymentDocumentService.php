<?php

namespace App\Modules\ClientPayment;

use App\Modules\Common\Image as Img;
use App\Libraries\Crud\CrudService;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Collection;
use App\Modules\FileUpload\FileUploadService;
use App\Modules\ClientPayment\PaymentDocument;
use App\Modules\ClientPayment\PaymentDocumentRepository;

class PaymentDocumentService extends CrudService
{
    protected array $allowedRelations = ['property', 'documents', 'assignee'];

    private PaymentDocumentRepository $documentRepository;
    private FileUploadService $fileUploadService;
    private ClientPaymentRepository $clientPaymentRepository;

    public function __construct(
        ClientPaymentRepository $clientPaymentRepository,
        PaymentDocumentRepository $repo,
        FileUploadService $fileUploadService
    ) {
        parent::__construct($repo);
        $this->fileUploadService = $fileUploadService;
        $this->clientPaymentRepository = $clientPaymentRepository;
        $this->documentRepository = $repo;
    }

    /**
     * @param string $fileType
     */
    public function isImage(string $fileType)
    {
        return in_array($fileType, Img::EXTENSIONS);
    }

    /**
     * @param string $documentId
     * @param string $paymentId
     * @return PaymentDocument
     */
    public function getOneOfPayment(string $documentId, string $paymentId): PaymentDocument
    {
        $document = $this->documentRepository->getOneOfPayment($documentId, $paymentId);
        $document || abort(404);

        return $document;
    }

    /**
     * string $imagePath
     */
    public function getImageContent(string $imagePath)
    {
        return Image::make(
            $this->fileUploadService->storage()->path($imagePath)
        );
    }

    /**
     * array $documents
     */
    public function changeFormat(Collection $documents): array
    {
        $data = [];
        foreach ($documents as $item) {
            $data[] = [
                'id' => $item->id ?? null,
                'client_payment_id' => $item->client_payment_id,
                'file_path' => $item->file_path,
                'file_url' => $item->id ? $this->url($item) : null,
                'file_type' => $item->file_type,
                'file_name' => $item->file_name,
                'created_at' => $item->created_at
            ];
        }

        return  $data;
    }
    /**
     * string $documentPath
     */
    public function fullPath(string $documentPath)
    {
        return $this->fileUploadService->storage()->path($documentPath);
    }

    /**
     * @param $document
     */
    public static function url($document): string
    {
        return url('api/payments/' . $document->client_payment_id . '/documents/' . $document->id);
    }
}