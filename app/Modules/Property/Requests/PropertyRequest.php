<?php

namespace App\Modules\Property\Requests;

use App\Libraries\Validation\Trait\HasSubRules;
use App\Modules\Common\Enum\Banner;
use App\Modules\Common\Enum\Ceiling;
use App\Modules\Common\Enum\DataSource;
use App\Modules\Common\Enum\DeedType;
use App\Modules\Common\Enum\DesignAppeal;
use App\Modules\Common\Enum\Direction;
use App\Modules\Common\Enum\Drainage;
use App\Modules\Common\Enum\FlooringMaterial;
use App\Modules\Common\Enum\FormLayout;
use App\Modules\Common\Enum\LandShape;
use App\Modules\Common\Enum\LengthUnit;
use App\Modules\Common\Enum\LocationAppeal;
use App\Modules\Common\Enum\Person;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Common\Enum\RoadCondition;
use App\Modules\Common\Enum\Roofing;
use App\Modules\Common\Enum\Sewerage;
use App\Modules\Common\Enum\Topography;
use App\Modules\Common\Enum\WindowFrame;
use App\Modules\Common\Enum\Zoning;
use App\Modules\Contact\Requests\ContactRequest;
use App\Modules\Property\Enum\ElectricitySupply;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\Property\Enum\Purpose;
use App\Modules\Property\Enum\WallMaterial;
use App\Modules\Property\Enum\WaterSupply;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PropertyRequest extends FormRequest
{
    use HasSubRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'property_type_id' => 'required',
            'company_id' => 'required',
            'company_branch_id' => 'required',
            'team_id' => 'required',
            'listing_purpose' => ['required', new Enum(Purpose::class)],
            'developer_id' => 'nullable',
            'project_id' => 'nullable',
            'title_deed_type' => ['nullable', new Enum(DeedType::class)],
            'title_deed_number' => ['nullable'],
            'data_source' => ['nullable', new Enum(DataSource::class)],
            'banner' => ['nullable', new Enum(Banner::class)],
            'valuation_report_number' => 'nullable',
            'listing_date' => 'nullable|date',
            'expired_listing_date' => 'nullable|date',

            // Renting info & Sale info
            'listing_status' => ['required', new Enum(ListingStatus::class)],
            'selling_price' => 'nullable|numeric',
            'selling_price_type' => ['nullable', new Enum(PriceType::class)],
            'renting_price' => 'nullable|numeric',
            'renting_price_type' => ['nullable', new Enum(PriceType::class)],
            'renting_terms' => 'nullable|numeric',
            'renting_deposit' => 'nullable|numeric',
            'tax_note' => 'nullable',
            'commission' => 'nullable|numeric',

            // Publish/Display options
            'publishing.published' => 'required|boolean',
            'publishing.published_on_website' => 'required|boolean',
            'publishing.featured' => 'nullable|boolean',
            'publishing.show_map' => 'nullable|boolean',
            'publishing.special' => 'nullable|boolean',
            'publishing.exclusive' => 'nullable|boolean',
            'publishing.recommended' => 'nullable|boolean',
            'publishing.description' => 'nullable',

            // Log info
            'assignee_id' => 'nullable',
            'assignor_id' => 'nullable',

            // Contact
            ...$this->subRules('owner_contact', [
                ...(new ContactRequest)->rules(),
                'name' => ['nullable', 'min:2'],
                'primary_phone' => ['nullable', new PhoneNumber],
            ]),


            ...$this->subRules('sale_contact', [
                ...(new ContactRequest)->rules(),
                'name' => ['nullable', 'min:2'],
                'primary_phone' => ['nullable', new PhoneNumber],
                'contact_person' => ['nullable', new Enum(Person::class)]
            ]),

            // Property Location
            ...$this->subRules('location', [
                'country_id' => 'required',
                'province_id' => 'required',
                'district_id' => 'required',
                'commune_id' => 'nullable',
                'village' => 'nullable',
                'street' => 'nullable',
                'house' => 'nullable',
                'cornered_with' => 'nullable',
                'street_view_link' => 'nullable',
                'lat_lng' => 'nullable',
                'direction' => ['nullable', new Enum(Direction::class)],
                'road_condition' => ['nullable', new Enum(RoadCondition::class)],
                'direct_road_width' => 'nullable|numeric',
            ]),

            // Facilities info
            ...$this->subRules('facilities', [
                'electricity_supply' => ['nullable', new Enum(ElectricitySupply::class)],
                'water_supply' => ['nullable', new Enum(WaterSupply::class)],
            ]),
            'other_facilities' => 'nullable',

            // DETAIL => Land Info
            ...$this->subRules('detail', [
                'land_width' => 'nullable|numeric',
                'land_length' => 'nullable|numeric',
                'land_size' => 'nullable|numeric',
                'land_size_unit' => ['nullable', new Enum(LengthUnit::class)],
                'land_shape' => ['nullable', new Enum(LandShape::class)],
                'zoning' => ['nullable', new Enum(Zoning::class)],
                'topography' => ['nullable', new Enum(Topography::class)],
                'sewerage' => ['nullable', new Enum(Sewerage::class)],
                'drainage' => ['nullable', new Enum(Drainage::class)],
                'location_appeal' => ['nullable', new Enum(LocationAppeal::class)],
                'current_used' => 'nullable',
                'surrounding_land_used' => 'nullable',

                // DETAIL => Building Info
                'building_width' => 'nullable|numeric',
                'building_length' => 'nullable|numeric',
                'number_of_stories' => 'nullable|numeric',
                'gross_building_area_size' => 'nullable|numeric',
                'warehouse_area_size' => 'nullable|numeric',
                'office_area_size' => 'nullable|numeric',
                'clear_height' => 'nullable|numeric',
                'available_floor' => 'nullable|integer',
                'floor_load_capacity' => 'nullable|numeric',
                'each_floor_size' => 'nullable|numeric',
                'building_main_wall' => ['nullable', new Enum(WallMaterial::class)],
                'ceiling' => ['nullable', new Enum(Ceiling::class)],
                'flooring_material' => ['nullable', new Enum(FlooringMaterial::class)],
                'roofing' => ['nullable', new Enum(Roofing::class)],
                'window_frame' => ['nullable', new Enum(WindowFrame::class)],
                'design_appeal' => ['nullable', new Enum(DesignAppeal::class)],
                'year_of_construction' => 'nullable|integer',
                'estimated_years_usable' => 'nullable|integer',
                'actual_age' => 'nullable|integer',
                'effective_age' => 'nullable|integer',
                'estimated_cost' => 'nullable|numeric',
                'number_of_mezzanines' => 'nullable|integer',
                'number_of_bedrooms' => 'nullable|integer',
                'number_of_bathrooms' => 'nullable|integer',

                // DETAIL => Business information
                'detail.stock_value' => 'nullable|numeric',
                'detail.fixture_value' => 'nullable|numeric',
                'detail.sale_revenue' => 'nullable|numeric',
                'detail.number_of_employees' => 'nullable|integer',
                'detail.trading_hours' => 'nullable|numeric',
                'detail.expansion_potential' => 'nullable',
                'detail.year_establish' => 'nullable|integer',
                'detail.selling_reason' => 'nullable|numeric',
            ]),

            // Other
            ...$this->subRules('other', [
                'form_layout' => ['required', new Enum(FormLayout::class)]
            ])
        ];
    }
}
