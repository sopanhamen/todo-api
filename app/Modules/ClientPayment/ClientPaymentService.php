<?php

namespace App\Modules\ClientPayment;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Libraries\Crud\CrudService;
use App\Modules\Property\PropertyService;
use App\Modules\ClientPayment\ClientPayment;
use App\Modules\FileUpload\FileUploadService;
use App\Modules\ClientPayment\PaymentDocumentRepository;

class ClientPaymentService extends CrudService
{
    protected array $allowedRelations = ['property', 'documents', 'assignee'];

    private PropertyService $propertyService;
    private FileUploadService $uploadService;
    private PaymentDocumentRepository $paymentService;
    public function __construct(
        ClientPaymentRepository $repo,
        PropertyService $propertyService,
        PaymentDocumentRepository $paymentService,
        FileUploadService $uploadService,
    ) {
        parent::__construct($repo);
        $this->propertyService = $propertyService;
        $this->paymentService = $paymentService;
        $this->uploadService = $uploadService;
    }

    public function createOne(array $payload): ?ClientPayment
    {
        return DB::transaction(function () use ($payload) {
            $property = $this->propertyService->getContacts($payload['property_id']);
            $payload['owner_contact_id'] = $property->owner_contact_id;

            return parent::createOne($payload);
        });
    }

    public function saveDocuments($paymentId, array $documents): Collection
    {
        $post = ClientPayment::findOrFail($paymentId);
        $data = [];
        foreach ($documents as $document) {
            $path = $this->uploadService->moveToRealPath($document['path'], 'payment/');
            $data[] = [
                'client_payment_id' => $paymentId,
                'file_path' => $path,
                'file_type' => $document['file_type'],
                'file_name' => $document['name'],
                'storage_disk' => config('filesystems.default'),
            ];
        }

        $post->documents()->createMany($data);

        return $this->paymentService->getPaymentDocuments($paymentId);
    }
}