<?php

namespace App\Modules\Property\Resources;

use App\Modules\Common\Enum\LengthUnit;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Contact\Resources\ContactResource;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\Property\Enum\Purpose;
use App\Modules\User\Resources\UserBasicInfoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyListingResource extends JsonResource
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
            'id' => $this->id,
            'code' => $this->code,
            'company_id' => $this->company_id,
            'company_branch_id' => $this->company_branch_id,
            'property_type_id' => $this->property_type_id,
            'team_id' => $this->team_id,
            'selling_price' => $this->selling_price,
            'selling_price_type' => $this->selling_price_type,
            'renting_price' => $this->renting_price,
            'renting_price_type' => $this->renting_price_type,
            'listing_purpose' => $this->listing_purpose,
            'listing_status' => $this->listing_status,
            'listing_date' => $this->listing_date,
            'expired_listing_date' => $this->expired_listing_date,
            'published' => $this->published,
            'exclusive' => $this->exclusive,
            'published' => $this->published,
            'published_on_website' => $this->published_on_website,
            'show_map' => $this->show_map,
            'location' => [
                'country_id' => $this->country_id,
                'province_id' => $this->province_id,
                'district_id' => $this->district_id,
                'commune_id' => $this->commune_id,
                'village' => $this->village,
                'street' => $this->street,
                'house' => $this->house,
                'lat_lng' => $this->lat_lng,
            ],
            'detail' => [
                'land_width' => $this->land_width,
                'land_length' => $this->land_length,
                'land_size' => $this->land_size,
                'land_size_unit' => $this->land_size_unit,
            ],
            'owner_contact' => new ContactResource($this->whenLoaded('ownerContact')),
            'sale_contact' => new ContactResource($this->whenLoaded('saleContact')),
            'images' => PropertyImageResource::collection($this->whenLoaded('images')),
            'documents' => PropertyDocumentResource::collection($this->whenLoaded('documents')),
            'assignee' => new UserBasicInfoResource($this->whenLoaded('assignee')),
            'assignor' => new UserBasicInfoResource($this->whenLoaded('assignor')),
            'property_type' => new UserBasicInfoResource($this->whenLoaded('propertyType')),
            'approved_by' => $this->approved_by,

            // todo: implement view count
            'view_counts' => 0
        ];
    }
}
