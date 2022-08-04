<?php

namespace App\Modules\Listing;

use App\Modules\Property\Property;
use App\Libraries\Crud\CrudService;
use App\Modules\Property\Enum\Purpose;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Property\Enum\ListingStatus;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Common\Enum\PropertyTypeGroup;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Modules\Listing\Resources\ListingResource;

class ListingService extends CrudService
{
    protected array $allowedRelations = [
        'propertyType', 'facilities', 'images', 'assignee', 'assignee.profile', 'assignee.profile.contact'
    ];

    protected array $filterable = [
        'property_type_group' => 'propertyType.property_type_group',
        'property_type_id' => 'property_type_id',
        'code' => 'code',
        'property_type_id' => 'property_type_id',
        'listing_purpose' => 'listing_purpose',

        'direction' => 'direction',
        'road_condition' => 'road_condition',

        'assignee_id' => 'assignee_id',
        'country_id' => 'country_id',
        'province_id' => 'province_id',
        'district_id' => 'district_id',
        'commune_id' => 'commune_id',
    ];

    protected ListingRepository $listingRepo;

    public function __construct(ListingRepository $repo)
    {
        parent::__construct($repo);
        $this->listingRepo = $repo;
    }

    /**
     * This value will we used to filter in every query using the service
     */
    public function onBeforeQuery(): ?callable
    {
        return function (Builder $query) {
            return $query->where('published_on_website', true)
                ->where('published', true)
                ->where('listing_status', ListingStatus::AVAILABLE->value)
                ->whereNotNull('approved_by');
        };
    }

    /**
     * Get all listings
     *
     * @param array $options
     * @return Collection
     */
    public function paginate(?array $options = null): Collection|LengthAwarePaginator
    {
        $queryOptions = $this->prepareOptions($options);
        $queryOptions['fields'] = [
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
            'number_of_bathrooms',
            'lat_lng'
        ];

        return $this->repo->paginate($queryOptions, $this->onBeforeQuery());
    }

    /**
     * Get one record which is not deleted by specified field (default = "id")
     *
     * @param mixed|null $value
     * @param string $field
     * @return null|Property
     */
    public function getOneOrFail(mixed $value, ?array $options = null): ?Property
    {
        $options = $this->prepareOptions(request()->query());
        $property = $this->repo->getOneOrFail($value, $options);

        $similarProperties = $this->listingRepo->getSimilarProperties($property);

        $property->related_properties = ListingResource::collection($similarProperties) ?? [];

        return $property;
    }

    public function getPropertyForRentSummary($counts): array
    {
        $homes = PropertyTypeGroup::HOMES->value;
        $landPlots = PropertyTypeGroup::LANDS_PLOTS->value;
        $commercial = PropertyTypeGroup::COMMERCIAL->value;
        $business = PropertyTypeGroup::BUSINESS->value;
        $industrial = PropertyTypeGroup::INDUSTRIAL->value;
        $petrolStation = PropertyTypeGroup::PETROL_STATION->value;

        $counts = $counts->where('listing_purpose', Purpose::RENT->value);
        $homeForRent = $counts->where('property_type_group', $homes)->first();
        $landForRent = $counts->where('property_type_group', $landPlots)->first();
        $commercialForRent = $counts->where('property_type_group', $commercial)->first();
        $businessForRent = $counts->where('property_type_group', $business)->first();
        $industrialForRent = $counts->where('property_type_group', $industrial)->first();
        $petrolStationForRent = $counts->where('property_type_group', $petrolStation)->first();

        return [
            'listing_purpose' => Purpose::RENT->value,
            'counts' => [
                ['property_type_group' => $homes, 'counts' => optional($homeForRent)->counts],
                ['property_type_group' => $landPlots, 'counts' => optional($landForRent)->counts],
                ['property_type_group' => $commercial, 'counts' => optional($commercialForRent)->counts],
                ['property_type_group' => $business, 'counts' => optional($businessForRent)->counts],
                ['property_type_group' => $industrial, 'counts' => optional($industrialForRent)->counts],
                ['property_type_group' => $petrolStation, 'counts' => optional($petrolStationForRent)->counts],
            ],
            'latests' => $this->listingRepo->getByPurpose(Purpose::RENT, 4),
        ];
    }

    public function getPropertyForSaleSummary($counts): array
    {
        $homes = PropertyTypeGroup::HOMES->value;
        $landPlots = PropertyTypeGroup::LANDS_PLOTS->value;
        $commercial = PropertyTypeGroup::COMMERCIAL->value;
        $business = PropertyTypeGroup::BUSINESS->value;
        $industrial = PropertyTypeGroup::INDUSTRIAL->value;
        $petrolStation = PropertyTypeGroup::PETROL_STATION->value;

        $counts = $counts->where('listing_purpose', Purpose::SALE->value);
        $homeForSale = $counts->where('property_type_group', $homes)->first();
        $landForSale = $counts->where('property_type_group', $landPlots)->first();
        $commercialForSale = $counts->where('property_type_group', $commercial)->first();
        $businessForSale = $counts->where('property_type_group', $business)->first();
        $industrialForSale = $counts->where('property_type_group', $industrial)->first();
        $petrolStationForSale = $counts->where('property_type_group', $petrolStation)->first();

        return [
            'listing_purpose' => Purpose::SALE->value,
            'counts' => [
                ['property_type_group' => $homes, 'counts' => optional($homeForSale)->counts],
                ['property_type_group' => $landPlots, 'counts' => optional($landForSale)->counts],
                ['property_type_group' => $commercial, 'counts' => optional($commercialForSale)->counts],
                ['property_type_group' => $business, 'counts' => optional($businessForSale)->counts],
                ['property_type_group' => $industrial, 'counts' => optional($industrialForSale)->counts],
                ['property_type_group' => $petrolStation, 'counts' => optional($petrolStationForSale)->counts],
            ],
            'latests' => $this->listingRepo->getByPurpose(Purpose::SALE, 4),
        ];
    }

    public function getPropertyForRentOrSaleSummary($counts): array
    {
        $homes = PropertyTypeGroup::HOMES->value;
        $landPlots = PropertyTypeGroup::LANDS_PLOTS->value;
        $commercial = PropertyTypeGroup::COMMERCIAL->value;
        $business = PropertyTypeGroup::BUSINESS->value;
        $industrial = PropertyTypeGroup::INDUSTRIAL->value;
        $petrolStation = PropertyTypeGroup::PETROL_STATION->value;

        $counts = $counts->where('listing_purpose', Purpose::RENT_OR_SALE->value);
        $homeForRentOrSale = $counts->where('property_type_group', $homes)->first();
        $landForRentOrSale = $counts->where('property_type_group', $landPlots)->first();
        $commercialForRentOrSale = $counts->where('property_type_group', $commercial)->first();
        $businessForRentOrSale = $counts->where('property_type_group', $business)->first();
        $industrialForRentOrSale = $counts->where('property_type_group', $industrial)->first();
        $petrolStationForRentOrSale = $counts->where('property_type_group', $petrolStation)->first();

        return [
            'listing_purpose' => Purpose::RENT_OR_SALE->value,
            'counts' => [
                ['property_type_group' => $homes, 'counts' => optional($homeForRentOrSale)->counts],
                ['property_type_group' => $landPlots, 'counts' => optional($landForRentOrSale)->counts],
                ['property_type_group' => $commercial, 'counts' => optional($commercialForRentOrSale)->counts],
                ['property_type_group' => $business, 'counts' => optional($businessForRentOrSale)->counts],
                ['property_type_group' => $industrial, 'counts' => optional($industrialForRentOrSale)->counts],
                ['property_type_group' => $petrolStation, 'counts' => optional($petrolStationForRentOrSale)->counts],
            ],
            'latests' => $this->listingRepo->getByPurpose(Purpose::RENT_OR_SALE, 4),
        ];
    }

    /**
     * @return array
     */
    public function getSummaries(int $limit = 2): array
    {
        $counts = $this->listingRepo->countByPropertyGroupAndPurpose();

        return [
            'total' => $counts->sum('counts'),
            'featured' => $this->listingRepo->getLastFeatured($limit),
            'data' => [
                $this->getPropertyForRentSummary($counts),
                $this->getPropertyForSaleSummary($counts),
                $this->getPropertyForRentOrSaleSummary($counts),
            ]
        ];
    }
}
