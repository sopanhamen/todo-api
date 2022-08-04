<?php

namespace App\Modules\SiteInquiry\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use App\Modules\Property\Resources\PropertyResource;

class SiteInquiryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'message' => Str::limit($this->message, 30, '...'),
            'url' => $this->url,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'property_id' => $this->property_id,
            'property' => new PropertyResource($this->whenLoaded('property')),
        ];
    }
}
