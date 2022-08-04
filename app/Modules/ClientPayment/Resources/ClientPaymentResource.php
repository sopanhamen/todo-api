<?php

namespace App\Modules\ClientPayment\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\ClientPayment\Resources\PaymentDocumentResource;

class ClientPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...parent::toArray($request),
            'documents' => PaymentDocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}