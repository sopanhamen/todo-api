<?php

namespace App\Modules\Common;


use App\Modules\Bank\Enum\InstituteType;
use App\Modules\Common\Enum\Ceiling;
use App\Modules\ClientRequirement\Enum\Service as ClientService;
use App\Modules\ClientRequirement\Enum\Result as RequirementResult;
use App\Modules\Client\Enum\ClientSource;
use App\Modules\Client\Enum\NegotiationStatus;
use App\Modules\Client\Enum\VisitingStatus;
use App\Modules\ClientType\ClientTypeService;
use App\Modules\Property\Enum\Purpose as ListingPurpose;
use App\Modules\Common\Enum\DataSource;
use App\Modules\Common\Enum\Banner;
use App\Modules\Common\Enum\DeedType;
use App\Modules\Common\Enum\DesignAppeal;
use App\Modules\Common\Enum\Direction;
use App\Modules\Common\Enum\Drainage;
use App\Modules\Property\Enum\ElectricitySupply;
use App\Modules\Common\Enum\FlooringMaterial;
use App\Modules\Common\Enum\FormLayout;
use App\Modules\Common\Enum\Gender;
use App\Modules\Common\Enum\LandShape;
use App\Modules\Common\Enum\LengthUnit;
use App\Modules\Common\Enum\LocationAppeal;
use App\Modules\Property\Enum\WallMaterial;
use App\Modules\Common\Enum\Person;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Common\Enum\Priority;
use App\Modules\Common\Enum\PropertyTypeGroup;
use App\Modules\Common\Enum\RoadCondition;
use App\Modules\Common\Enum\Roofing;
use App\Modules\Common\Enum\Sewerage;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\Common\Enum\Topography;
use App\Modules\Common\Enum\RoomType;
use App\Modules\Property\Enum\WaterSupply;
use App\Modules\Common\Enum\WindowFrame;
use App\Modules\Common\Enum\Zoning;
use App\Modules\Commune\CommuneService;
use App\Modules\Company\CompanyService;
use App\Modules\CompanyBranch\CompanyBranchService;
use App\Modules\Country\CountryService;
use App\Modules\Developer\DeveloperService;
use App\Modules\DevelopmentType\DevelopmentTypeService;
use App\Modules\District\DistrictService;
use App\Modules\Facility\FacilityService;
use App\Modules\PropertyType\PropertyTypeService;
use App\Modules\Province\ProvinceService;
use Illuminate\Support\Facades\Cache;

class ResourceService
{
    private ClientTypeService $clientTypeService;
    private PropertyTypeService $propertyTypeService;
    private FacilityService $facilityService;
    private CompanyService $companyService;
    private CompanyBranchService $companyBranchService;
    private DeveloperService $developerService;
    private DevelopmentTypeService $developmentTypeService;
    private CountryService $countryService;
    private ProvinceService $provinceService;
    private DistrictService $districtService;
    private CommuneService $communeService;

    public $staticCacheName = 'static_resources';

    public function __construct(
        ClientTypeService $clientTypeService,
        PropertyTypeService $propertyTypeService,
        FacilityService $facilityService,
        CompanyService $companyService,
        CompanyBranchService $companyBranchService,
        DeveloperService $developerService,
        DevelopmentTypeService $developmentTypeService,
        CountryService $countryService,
        ProvinceService $provinceService,
        DistrictService $districtService,
        CommuneService $communeService,
    ) {
        $this->clientTypeService = $clientTypeService;
        $this->propertyTypeService = $propertyTypeService;
        $this->facilityService = $facilityService;
        $this->companyService = $companyService;
        $this->companyBranchService = $companyBranchService;
        $this->developerService = $developerService;
        $this->developmentTypeService = $developmentTypeService;
        $this->countryService = $countryService;
        $this->provinceService = $provinceService;
        $this->districtService = $districtService;
        $this->communeService = $communeService;
    }

    /**
     * Get all resources data
     */
    public function getResources(?array $resources = null): array
    {
        return [
            ...$this->getDynamicResources($resources),
            ...$this->getStaticResources(),
        ];
    }

    /**
     * Get all database stored resources data
     */
    public function getDynamicResources(?array $resources = null): array
    {
        $result = [];
        if (!$resources || in_array('client_types', $resources)) {
            $result['client_types'] = $this->clientTypeService->getFromCache(['id', 'name', 'published']);
        }

        if (!$resources || in_array('property_types', $resources)) {
            $result['property_types'] = $this->propertyTypeService->getFromCache(
                ['id', 'name', 'property_type_group', 'published']
            );
        }

        if (!$resources || in_array('facilities', $resources)) {
            $result['facilities'] = $this->facilityService->getFromCache(
                ['id', 'code', 'name', 'published']
            );
        }

        if (!$resources || in_array('companies', $resources)) {
            $result['companies'] = $this->companyService->getFromCache();
        }

        if (!$resources || in_array('company_branches', $resources)) {
            $result['company_branches'] = $this->companyBranchService->getFromCache();
        }

        if (!$resources || in_array('developers', $resources)) {
            $result['developers'] = $this->developerService->getFromCache(['id', 'name', 'published', 'development_type_id']);
        }
        if (!$resources || in_array('development_types', $resources)) {
            $result['development_types'] = $this->developmentTypeService->getFromCache(['id', 'name', 'published']);
        }

        if (!$resources || in_array('countries', $resources)) {
            $result['countries'] = $this->countryService->getFromCache([
                'id', 'name', 'iso_code', 'code', 'published'
            ]);
        }

        if (!$resources || in_array('provinces', $resources)) {
            $result['provinces'] = $this->provinceService->getFromCache([
                'id', 'name_en', 'name_km', 'country_id', 'published'
            ]);
        }

        if (!$resources || in_array('districts', $resources)) {
            $result['districts'] = $this->districtService->getFromCache([
                'id', 'name_en', 'name_km', 'province_id', 'published'
            ]);
        }

        if (!$resources || in_array('communes', $resources)) {
            $result['communes'] = $this->communeService->getFromCache([
                'id', 'name_en', 'name_km', 'district_id', 'published'
            ]);
        }

        return $result;
    }

    /**
     * Get all static resources data
     */
    public function getStaticResources(): array
    {
        return Cache::rememberForever($this->staticCacheName, function () {
            return [
                'listing_purposes' => ListingPurpose::labels(),
                'listing_status' => ListingStatus::labels(),

                'property_type_groups' => PropertyTypeGroup::labels(),

                'client_sources' => ClientSource::labels(),
                'requirement_services' => ClientService::labels(),
                'requirement_results' => RequirementResult::labels(),

                'ceiling' => Ceiling::labels(),
                'data_source' => DataSource::labels(),
                'banner' => Banner::labels(),
                'deed_type' => DeedType::labels(),
                'design_appeal' => DesignAppeal::labels(),
                'direction' => Direction::labels(),
                'drainage' => Drainage::labels(),
                'electricity' => ElectricitySupply::labels(),
                'flooring_material' => FlooringMaterial::labels(),
                'form_layouts' => FormLayout::labels(),
                'gender' => Gender::labels(),
                'institute_type' => InstituteType::labels(),
                'land_shape' => LandShape::labels(),
                'length_units' => LengthUnit::labels(),
                'location_appeal' => LocationAppeal::labels(),
                'negotiation_status' => NegotiationStatus::labels(),
                'wall_materials' => WallMaterial::labels(),
                'person' => Person::labels(),
                'priority' => Priority::labels(),
                'road_condition' => RoadCondition::labels(),
                'roofing' => Roofing::labels(),
                'sewerage' => Sewerage::labels(),
                'topography' => Topography::labels(),
                'price_type' => PriceType::labels(),
                'room_type' => RoomType::labels(),
                'visit_status' => VisitingStatus::labels(),
                'water' => WaterSupply::labels(),
                'window_frame' => WindowFrame::labels(),
                'zoning' => Zoning::labels(),
            ];
        });
    }
}
