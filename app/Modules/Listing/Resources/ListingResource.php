<?php

namespace App\Modules\Listing\Resources;

use App\Modules\Common\Enum\PriceType;
use App\Modules\Property\Resources\PropertyImageResource;
use App\Modules\PropertyType\Resources\PropertyTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\User\Resources\UserBasicInfoResource;

class ListingResource extends JsonResource
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
            'listing_purpose' => $this->listing_purpose,
            'property_type_id' => $this->property_type_id,
            'property_type' => new PropertyTypeResource($this->whenLoaded('propertyType')),


            'selling_price' => $this->selling_price,
            'selling_price_type' => $this->selling_price_type,
            'renting_price' => $this->renting_price,
            'renting_price_type' => $this->renting_price_type,

            'land_width' => $this->land_width,
            'land_length' => $this->land_length,
            'land_size' => $this->land_size,
            'land_size_unit' => $this->land_size_unit ?? null,

            'building_width' => $this->building_width,
            'building_length' => $this->building_length,
            'gross_building_area_size' => $this->gross_building_area_size,

            'listing_status' => $this->listing_status,
            'number_of_bedrooms' => $this->number_of_bedrooms,
            'number_of_bathrooms' => $this->number_of_bathrooms,

            'images' => PropertyImageResource::collection($this->whenLoaded('images')),
            'assignee' => new UserBasicInfoResource($this->whenLoaded('assignee')),

            'location' => [
                'country_id' => $this->country_id,
                'province_id' => $this->province_id,
                'district_id' => $this->district_id,
                'commune_id' => $this->commune_id,
                'lat_lng' => $this->lat_lng,
            ],

            'publishing' => [
                'exclusive' => $this->exclusive,
                'featured' => $this->featured,
                'show_map' => $this->show_map,
            ]
        ];
    }
}
