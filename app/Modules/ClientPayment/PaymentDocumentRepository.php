<?php

namespace App\Modules\ClientPayment;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Libraries\Crud\CrudRepository;
use App\Modules\ClientPayment\PaymentDocument;

class PaymentDocumentRepository extends CrudRepository
{
    public function __construct(PaymentDocument $paymentDocument)
    {
        parent::__construct($paymentDocument);
    }

    /**
     * string $propertyId
     */
    public function getAll(string $paymentId, $fields = ['*'])
    {
        return PaymentDocument::select($fields)->where('property_id', $paymentId)->get();
    }

    /**
     * @param string $documentId
     * @param string $paymentId
     * @return null|PaymentDocument
     */
    public function getOneOfPayment(string $documentId, string $paymentId): ?PaymentDocument
    {
        return $this->model
            ->where('id', $documentId)
            ->where('client_payment_id', $paymentId)
            ->select(['id', 'file_path', 'file_type'])
            ->first();
    }

    /**
     * @param string $paymentId
     * @return null|Collection
     */
    public function getPaymentDocuments(string $paymentId): Collection
    {
        return DB::table('payment_documents')
            ->where('client_payment_id', $paymentId)
            ->whereNull('deleted_at')
            ->get();
    }
}