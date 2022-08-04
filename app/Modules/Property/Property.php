<?php

namespace App\Modules\Property;

use App\Libraries\Crud\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Database\Traits\HasAuthors;
use App\Libraries\Database\Traits\UuidPrimaryKey;
use App\Modules\Contact\Contact;
use App\Modules\Developer\Developer;
use App\Modules\Facility\Facility;
use App\Modules\Project\Project;
use App\Modules\PropertyType\PropertyType;
use App\Modules\SiteInquiry\SiteInquiry;
use App\Modules\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Property extends CrudModel implements Auditable
{
    use UuidPrimaryKey,
        Notifiable,
        SoftDeletes,
        HasAuthors,
        HasFactory,
        \OwenIt\Auditing\Auditable;

    protected $casts = [
        'listing_date' => 'datetime',
        'expired_listing_date' => 'datetime',
        'listing_purpose' => 'integer',
        'title_deed_type' => 'integer',
        'data_source' => 'integer',
        'listing_status' => 'integer',
        'selling_price_type' => 'integer',
        'renting_price_type' => 'integer',
        'sale_contact_person' => 'integer',
        'direction' => 'integer',
        'road_condition' => 'integer',
        'banner' => 'integer',

        // Detail
        'land_width' => 'double',
        'land_length' => 'double',
        'land_size' => 'double',
        'land_size_unit' => 'integer',
        'land_size_unit' => 'integer',
        'land_shape' => 'integer',
        'zoning' => 'integer',
        'topography' => 'integer',
        'sewerage' => 'integer',
        'drainage' => 'integer',
        'location_appeal' => 'integer',
        'electricity_supply' => 'integer',
        'water_supply' => 'integer',
        'building_main_wall' => 'integer',
        'ceiling' => 'integer',
        'flooring_material' => 'integer',
        'roofing' => 'integer',
        'window_frame' => 'integer',
        'design_appeal' => 'integer',
        'form_layout' => 'integer',
        'number_of_bathrooms' => 'integer',
        'number_of_bedrooms' => 'integer',
        'number_of_mezzanines' => 'integer',
        'number_of_employees' => 'integer',
        'number_of_stories' => 'float',
    ];

    public $fillable = [
        // Property basic Info
        'code',
        'unlisting_code',
        'company_id',
        'company_branch_id',
        'team_id',
        'property_type_id',
        'developer_id',
        'project_id',
        'listing_purpose',
        'title_deed_type',
        'title_deed_number',
        'banner',
        'data_source',
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
        'commission',

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
        'approved_by',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class, 'property_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PropertyDocument::class, 'property_id');
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'property_facilities', 'property_id', 'facility_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function assignor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignor_id');
    }

    public function ownerContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'owner_contact_id', 'id');
    }

    public function saleContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'sale_contact_id', 'id');
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function siteInquiry(): HasMany
    {
        return $this->hasMany(SiteInquiry::class, 'property_id');
    }
}
