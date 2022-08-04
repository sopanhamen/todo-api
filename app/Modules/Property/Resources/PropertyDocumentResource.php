<?php

namespace App\Modules\Property\Resources;

use App\Modules\Property\PropertyDocumentService;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyDocumentResource extends JsonResource
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
            'file_path' => $this->file_path,
            'file_url' => $this->id ? PropertyDocumentService::url($this->resource) : null,
            'file_type' => $this->file_type,
            'file_name' => $this->file_name,
            'created_at' => $this->created_at
        ];
    }
}
