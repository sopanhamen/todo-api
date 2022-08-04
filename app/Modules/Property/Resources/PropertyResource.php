<?php

namespace App\Modules\Property\Resources;

use App\Modules\Contact\Resources\ContactResource;
use App\Modules\Developer\Resources\DeveloperResource;
use App\Modules\PropertyType\Resources\PropertyTypeResource;
use App\Modules\User\Resources\UserBasicInfoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
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
            'team_id' => $this->team_id,

            'property_type_id' => $this->property_type_id,
            'property_type' => new PropertyTypeResource($this->whenLoaded('propertyType')),

            'developer_id' => $this->developer_id,
            'developer' => new DeveloperResource($this->whenLoaded('developer')),

            'project_id' => $this->project_id,
            'project' => new DeveloperResource($this->whenLoaded('project')),

            'listing_purpose' => $this->listing_purpose ?? null,
            'title_deed_type' => $this->title_deed_type ?? null,
            'title_deed_number' => $this->title_deed_number,
            'data_source' => $this->data_source ?? null,
            'banner' => $this->banner ?? null,
            'valuation_report_number' => $this->valuation_report_number,
            'listing_date' => $this->listing_date,
            'expired_listing_date' => $this->expired_listing_date,
            'listing_status' => $this->listing_status ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Sale
            'selling_price' => $this->selling_price,
            'selling_price_type' => $this->selling_price_type ?? null,

            // Rent
            'renting_price' => $this->renting_price,
            'renting_price_type' => $this->renting_price_type,
            'renting_terms' => $this->renting_terms,
            'renting_deposit' => $this->renting_deposit,
            'tax_note' => $this->tax_note,
            'commission' => $this->commission,
            'sale_note' => $this->sale_note,
            'publishing' => [
                'published' => $this->published,
                'published_on_website' => $this->published_on_website,
                'exclusive' => $this->exclusive,
                'featured' => $this->featured,
                'show_map' => $this->show_map,
                'description' => $this->description,
            ],
            'detail' => [
                // land
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

                // building
                'building_width' => $this->building_width,
                'building_length' => $this->building_length,
                'number_of_stories' => $this->number_of_stories,
                'gross_building_area_size' => $this->gross_building_area_size,
                'building_main_wall' => $this->building_main_wall,
                'ceiling' => $this->ceiling,
                'flooring_material' => $this->flooring_material,
                'roofing' => $this->roofing,
                'window_frame' => $this->window_frame,
                'design_appeal' => $this->design_appeal,
                'year_of_construction' => $this->year_of_construction,
                'estimated_years_usable' => $this->estimated_years_usable,
                'actual_age' => $this->actual_age,
                'effective_age' => $this->effective_age,
                'estimated_cost' => $this->estimated_cost,
                'number_of_mezzanines' => $this->number_of_mezzanines,
                'number_of_bedrooms' => $this->number_of_bedrooms,
                'number_of_bathrooms' => $this->number_of_bathrooms,

                // business
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
                return $this->facilities->map(fn ($facility) => $facility->only(['id', 'name']));
            }),
            'other' => [
                'form_layout' => $this->form_layout ?? null
            ],
            'owner_contact' => new ContactResource($this->whenLoaded('ownerContact')),
            'sale_contact' => $this->whenLoaded('saleContact', fn () => ([
                'id' => $this->saleContact->id,
                'name' => $this->saleContact->name,
                'email' => $this->saleContact->email,
                'primary_phone' => $this->saleContact->primary_phone,
                'secondary_phone' => $this->saleContact->secondary_phone,
                'telegram' => $this->saleContact->telegram,
                'line' => $this->saleContact->line,
                'wechat' => $this->saleContact->wechat,
                'contact_person' => $this->sale_contact_person,
            ])),
            'images' => PropertyImageResource::collection($this->whenLoaded('images')),
            'documents' => PropertyDocumentResource::collection($this->whenLoaded('documents')),
            'assignee_id' => $this->assignee_id,
            'assignee' => new UserBasicInfoResource($this->whenLoaded('assignee')),
            'assignor_id' => $this->assignor_id,
            'assignor' => new UserBasicInfoResource($this->whenLoaded('assignor')),
            'approved_by' => $this->approved_by,
            'approver' => new UserBasicInfoResource($this->whenLoaded('approver')),

            // todo: implement view count
            'view_counts' => 0
        ];
    }
}
