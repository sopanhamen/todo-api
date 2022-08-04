<?php

namespace App\Modules\Listing;

use App\Libraries\Crud\CrudRepository;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\Property\Enum\Purpose;
use App\Modules\Property\Property;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ListingRepository extends CrudRepository
{
    public function __construct(Property $property)
    {
        parent::__construct($property);
    }

    public function getByPurpose(Purpose $purpose, int $limit = 4): EloquentCollection
    {
        $fields = [
            'id',
            'code',
            'property_type_id',
            'listing_purpose',
            'selling_price',
            'selling_price_type',
            'renting_price',
            'renting_price_type',
            'land_width',
            'land_length',
            'land_size',
            'land_size_unit',
            'building_width',
            'building_length',
            'gross_building_area_size',
            'exclusive',
            'country_id',
            'province_id',
            'district_id',
            'commune_id',
            'village',
            'street',
            'assignee_id',
            'listing_status',
            'number_of_bedrooms',
            'number_of_bathrooms'
        ];

        return $this->model
            ->with('images', 'propertyType', 'assignee', 'assignee.profile', 'assignee.profile.contact')
            ->select($fields)
            ->where('listing_purpose', $purpose->value)
            ->where('published', true)
            ->where('published_on_website', true)
            ->where('listing_status', ListingStatus::AVAILABLE->value)
            ->whereNull('deleted_at')
            ->whereNotNull('approved_by')
            ->orderBy('listing_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getLastFeatured(int $limit = 2): EloquentCollection
    {
        $fields = [
            'id',
            'code',
            'property_type_id',
            'listing_purpose',
            'selling_price',
            'selling_price_type',
            'renting_price',
            'renting_price_type',
            'land_width',
            'land_length',
            'land_size',
            'land_size_unit',
            'building_width',
            'building_length',
            'gross_building_area_size',
            'exclusive',
            'country_id',
            'province_id',
            'district_id',
            'commune_id',
            'village',
            'street',
        ];

        return $this->model
            ->with('images', 'propertyType')
            ->select($fields)
            ->where('featured', true)
            ->where('published', true)
            ->where('published_on_website', true)
            ->where('listing_status', ListingStatus::AVAILABLE->value)
            ->whereNotNull('approved_by')
            ->whereNull('deleted_at')
            ->orderBy('listing_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function countByPropertyGroupAndPurpose(): Collection
    {
        return DB::table('properties')
            ->select('pt.property_type_group', 'listing_purpose')
            ->selectRaw('COUNT(pt.id) as counts')
            ->join('property_types as pt', 'pt.id', '=', 'properties.property_type_id')
            ->where('properties.published', true)
            ->where('properties.published_on_website', true)
            ->whereNotNull('properties.approved_by')
            ->where('listing_status', ListingStatus::AVAILABLE->value)
            ->whereNull('properties.deleted_at')
            ->groupBy('pt.property_type_group', 'listing_purpose')
            ->get();
    }

    public function getSimilarProperties($property, $limit = 2): EloquentCollection
    {
        return $this->model->with('images', 'propertyType')
            ->where('published', true)
            ->where('published_on_website', true)
            ->where('listing_status', ListingStatus::AVAILABLE->value)
            ->whereNotNull('approved_by')
            ->where('id', '!=',  $property->id)
            ->where('property_type_id', $property->property_type_id)
            ->where('listing_purpose', $property->listing_purpose)
            ->where('country_id',  $property->country_id)
            ->where('province_id',  $property->province_id)
            ->whereNull('deleted_at')
            ->limit($limit)
            ->get();
    }
}
