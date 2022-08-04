<?php

namespace App\Modules\Company\Resources;

use App\Modules\FileUpload\FileUploadService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\CompanyBranch\Resources\CompanyBranchResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $fileUploadService = new FileUploadService();

        return [
            "id" => $this->id,
            "name" => $this->name,
            "property_code_prefix" => $this->property_code_prefix,
            "property_code_digit" => $this->property_code_digit,
            'property_code_prefix_unlisting' => $this->property_code_prefix_unlisting,
            'property_code_digit_unlisting' => $this->property_code_digit_unlisting,

            "year_established" => $this->year_established,
            "summary" => $this->summary,
            "description" => $this->description,
            "vision" => $this->vision,
            "mission" => $this->mission,
            "key_value" => $this->key_value,
            "address" => $this->address,
            "primary_phone" => $this->primary_phone,
            "secondary_phone" => $this->secondary_phone,
            "email" => $this->email,
            "facebook" => $this->facebook,
            "telegram" => $this->telegram,
            "youtube" => $this->youtube,
            "linked_in" => $this->linked_in,
            "instagram" => $this->instagram,
            "logo" =>  [
                'url' => $fileUploadService->url($this->logo, null, $this->logo_disk),
                'path' => $this->logo
            ],
            "lat_lng" => $this->lat_lng,
            "published" => $this->published,
            "country_id" => $this->country_id,
            "province_id" => $this->province_id,
            "district_id" => $this->district_id,
            "commune_id" => $this->commune_id,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            'branches' => new CompanyBranchResource($this->whenLoaded('branches'))
        ];
    }
}
