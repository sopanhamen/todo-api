<?php

namespace App\Modules\Listing\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\User\Resources\UserBasicInfoResource;
use App\Modules\Property\Resources\PropertyImageResource;
use App\Modules\PropertyType\Resources\PropertyTypeResource;

class ListingDetailResource extends JsonResource
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
            'property_type_id' => $this->property_type_id,
            'property_type' => new PropertyTypeResource($this->whenLoaded('propertyType')),

            'listing_purpose' => $this->listing_purpose ?? null,
            'title_deed_type' => $this->title_deed_type ?? null,
            'banner' => $this->banner ?? null,

            'valuation_report_number' => $this->valuation_report_number,
            'listing_date' => $this->listing_date,
            'expired_listing_date' => $this->expired_listing_date,
            'listing_status' => $this->listing_status ?? null,

            // Sale
            'selling_price' => $this->selling_price,
            'selling_price_type' => $this->selling_price_type ?? null,

            // Rent
            'renting_price' => $this->renting_price,
            'renting_price_type' => $this->renting_price_type,
            'renting_terms' => $this->renting_terms,
            'renting_deposit' => $this->renting_deposit,
            'tax_note' => $this->tax_note,
            'commission' => $this->commission ?? null,
            'sale_note' => $this->sale_note,

            'publishing' => [
                'published' => $this->published,
                'published_on_website' => $this->published_on_website,
                'exclusive' => $this->exclusive,
                'show_map' => $this->show_map,
                'description' => $this->description,
            ],

            'land' => [
                'land_width' => $this->land_width,
                'land_length' => $this->land_length,
                'land_size' => $this->land_size,
                'land_size_unit' => $this->land_size_unit ?? null,
                'land_shape' => $this->land_shape ?? null,
                'zoning' => $this->zoning ?? null,
                'topography' => $this->topography ?? null,
                'sewerage' => $this->sewerage ?? null,
                'drainage' => $this->drainage ?? null,
                'location_appeal' => $this->location_appeal ?? null,
                'current_used' => $this->current_used,
                'surrounding_land_used' => $this->surrounding_land_used,

            ],

            'building' => [
                'building_width' => $this->building_width,
                'building_length' => $this->building_length,
                'number_of_stories' => $this->number_of_stories,
                'gross_building_area_size' => $this->gross_building_area_size,
            ],

            'business' => [
                'stock_value' => $this->stock_value,
                'fixture_value' => $this->fixture_value,
                'sale_revenue' => $this->sale_revenue,
                'number_of_employees' => $this->number_of_employees,
                'trading_hours' => $this->trading_hours,
                'expansion_potential' => $this->expansion_potential,
                'year_establish' => $this->year_establish,
                'selling_reason' => $this->selling_reason,
            ],

            'location' => [
                'country_id' => $this->country_id,
                'province_id' => $this->province_id,
                'district_id' => $this->district_id,
                'commune_id' => $this->commune_id,
                'village' => $this->village,
                'street' => $this->street,
                'house' => $this->house,
                'cornered_with' => $this->cornered_with,
                'lat_lng' => $this->lat_lng,
                'direction' => $this->direction,
                'road_condition' => $this->road_condition,
                'direct_road_width' => $this->direct_road_width,
            ],

            'facilities' => [
                'electricity_supply' => $this->electricity_supply ?? null,
                'water_supply' => $this->water_supply ?? null,
            ],

            'other_facilities' => $this->whenLoaded('facilities', function () {
                return $this->facilities->map(function ($facility) {
                    return [
                        'id' => $facility->id,
                        'name' => $facility->name,
                        'code' => $facility->code,
                    ];
                });
            }),

            'form_layout' => $this->form_layout ?? null,

            'images' => PropertyImageResource::collection($this->whenLoaded('images')),

            // Listing Agent
            'assignee' => new UserBasicInfoResource($this->whenLoaded('assignee')),

            'related_properties' => $this->related_properties,
        ];
    }
}