<?php

namespace App\Modules\ClientPayment\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\ClientPayment\PaymentDocumentService;

class PaymentDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id ?? null,
            'client_payment_id' => $this->client_payment_id,
            'file_path' => $this->file_path,
            'file_url' => $this->id ? PaymentDocumentService::url($this->resource) : null,
            'file_type' => $this->file_type,
            'file_name' => $this->file_name,
            'created_at' => $this->created_at
        ];
    }
}
