<?php

namespace App\Modules\PropertyHistory;

use App\Modules\Property\Property;

class PropertyHistory extends Property
{
    protected $casts = [
        'listing_date' => 'datetime',
        'expired_listing_date' => 'datetime',
    ];

    public $fillable = [
        // Property basic Info
        'property_id',
        'code',
        'company_id',
        'company_branch_id',
        'team_id',
        'property_type_id',
        'developer_id',
        'project_id',
        'listing_purpose',
        'title_deed_type',
        'title_deed_number',
        'data_source',
        'banner',
        'valuation_report_number',

        // Listing info
        'listing_date',
        'expired_listing_date',
        'listing_status',
        'selling_price',
        'selling_price_type',
        'renting_price',
        'renting_price_type',

        // Contact & Sale info
        'owner_contact_id',
        'sale_contact_id',
        'sale_contact_person',
        'sale_note',
        'renting_terms',
        'renting_deposit',
        'tax_note',

        // Property Location
        'country_id',
        'province_id',
        'district_id',
        'commune_id',
        'village',
        'street',
        'house',
        'cornered_with',
        'street_view_link',
        'lat_lng',
        'direction',
        'road_condition',
        'direct_road_width',

        // Land info
        'land_width',
        'land_length',
        'land_size',
        'land_size_unit',
        'land_shape',
        'zoning',
        'topography',
        'sewerage',
        'drainage',
        'location_appeal',
        'current_used',
        'surrounding_land_used',

        // Building Info
        'building_width',
        'building_length',
        'number_of_stories',
        'gross_building_area_size',
        'warehouse_area_size',
        'office_area_size',
        'clear_height',
        'available_floor',
        'floor_load_capacity',
        'each_floor_size',
        'building_main_wall',
        'ceiling',
        'flooring_material',
        'roofing',
        'window_frame',
        'design_appeal',
        'year_of_construction',
        'estimated_years_usable',
        'actual_age',
        'effective_age',
        'estimated_cost',
        'number_of_mezzanines',
        'number_of_bedrooms',
        'number_of_bathrooms',

        // Business information
        'stock_value',
        'fixture_value',
        'sale_revenue',
        'number_of_employees',
        'trading_hours',
        'expansion_potential',
        'year_establish',
        'selling_reason',

        // Facilities info
        'electricity_supply',
        'water_supply',

        // Publish/Display options
        'published',
        'published_on_website',
        'featured',
        'special',
        'exclusive',
        'recommended',
        'description',
        'show_map',

        // Other
        'form_layout',

        // Log info
        'assignee_id',
        'assignor_id',
    ];
}
