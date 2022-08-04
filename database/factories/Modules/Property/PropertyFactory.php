<?php

namespace Database\Factories\Modules\Property;

use Illuminate\Support\Carbon;
use App\Modules\Property\Property;
use App\Modules\Common\Enum\DeedType;
use App\Modules\Common\Enum\Direction;
use App\Modules\Common\Enum\LandShape;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Property\Enum\Purpose;
use App\Modules\Common\Enum\FormLayout;
use App\Modules\Common\Enum\LengthUnit;
use App\Modules\Common\Enum\RoadCondition;
// use App\Modules\CompanyBranch\CompanyBranch;
use App\Modules\Contact\Contact;
use App\Modules\Property\Enum\ListingStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $id = 1;

        $width = $this->faker->numberBetween(1, 50);
        $length = $this->faker->numberBetween(50, 100);
        $salePrice = $this->faker->randomElement([15000, 10000, 15000, 20000, 40000, 120000, 200000, 300000]);
        $rentPrice = $this->faker->randomElement([50, 100, 200, 400, 1000, 3000,]);
        $purpose = $this->faker->randomElement((array_column(Purpose::cases(), 'value')));
        $listingStatus = $this->faker->randomElement((array_column(ListingStatus::cases(), 'value')));

        if ($purpose === Purpose::SALE) {
            $rentPrice = null;
            $listingStatus = $this->faker->randomElement([ListingStatus::AVAILABLE->value, ListingStatus::STOP_SELLING->value, ListingStatus::SOLD]);
        } elseif ($purpose === Purpose::RENT) {
            $salePrice = null;
            $listingStatus = $this->faker->randomElement([ListingStatus::AVAILABLE->value, ListingStatus::STOP_RENTING->value, ListingStatus::RENTED]);
        }

        $companyId = '4f7e0ea0-5437-445f-a579-cd6bb90c98e0';

        $branches = CompanyBranch::with('teams', 'teams.users')->where('company_id', $companyId)->get();
        $branch = $branches->random();
        $branchId = $branch->id;

        $team = $branch->teams->random();
        $teamId = $team->id;

        $superAdminId = config('user.default_user.super_admin.id');
        $assigneeId = $superAdminId;
        if ($team->users->count() > 0) {
            $user = $team->users->random();
            $assigneeId = $user->id;
        }

        $phones = [
            $this->faker->numerify('+855########'), // 6 digits phone number
            $this->faker->numerify('+855#########', 2) // 7 digits phone number
        ];
        $primaryPhone = $phones[$this->faker->numberBetween(0, 1)];
        $ownerContact = Contact::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'primary_phone' => $primaryPhone,
        ]);

        $communesOfDistrict = [
            [
                'id' => 'c7579555-0732-44ab-81c4-0d8c998f558f',
                'communes' => ['8d504b6f-8b9d-4fdd-a363-ac150a792763'],
            ],
            [
                'id' => 'ed1b68fc-2f6b-463f-8e86-66068841cc50',
                'communes' =>  ['4b0bb455-24d2-4910-9524-c13bcaca1b88']
            ],
            [
                'id' => 'bc84d21c-487e-42b4-b9dc-c407a64958b4',
                'communes' => ['14df0dbc-4b89-4676-a84e-324e049115df']
            ],
            [
                'id' => 'ae6f3b52-4ead-4392-8b55-2b076f2ffa4b',
                'communes' => ['22b0c54a-1725-49b2-b63f-0e6bfb5870f7']
            ],
            [
                'id' => '61276821-8ddc-4893-97ec-48d989659546',
                'communes' => ['b3d856d5-cdea-49db-9888-6b8987014356']
            ],
        ];

        $district = $communesOfDistrict[$this->faker->numberBetween(0, 4)];
        $districtId = $district['id'];
        $communeId = $this->faker->randomElement($district['communes']);

        $projectIds = [
            '642ebbf4-9ec8-4ad1-98bc-b2d2dfbe05ee',
            '4ead5bdb-4b73-48fc-bccc-154212337f7d',
            '63730155-a2b1-4654-a1c3-62151f51f2f4'
        ];

        return [
            "id" => $this->faker->uuid(),
            "code" => 'MK-' . Str::padLeft($id++, 5, '0'),
            'company_id' => $companyId,
            'company_branch_id' => $branchId,
            'team_id' => $teamId,
            "property_type_id" => $this->faker->numberBetween(1, 51),
            "developer_id" => $this->faker->numberBetween(1, 5),
            "project_id" => $this->faker->randomElement($projectIds),
            "listing_purpose" => $purpose,
            "title_deed_type" => $this->faker->randomElement((array_column(DeedType::cases(), 'value'))),
            "title_deed_number" => $this->faker->numberBetween(1, 10),
            "data_source" => $this->faker->numberBetween(1, 3),
            "valuation_report_number" => $this->faker->numberBetween(10000, 99999),
            "listing_date" => $this->faker->dateTimeThisMonth(),
            "expired_listing_date" => date_add(
                $this->faker->dateTimeThisMonth(),
                date_interval_create_from_date_string('90 days')
            ),
            "listing_status" => $listingStatus,
            "selling_price" => $salePrice,
            "selling_price_type" => PriceType::TOTAL,
            "renting_price" => $rentPrice,
            "renting_price_type" => PriceType::MONTH,
            "owner_contact_id" => $ownerContact->id,
            "sale_contact_id" => null,
            "sale_contact_person" => null,
            "sale_note" => null,
            "renting_terms" => null,
            "renting_deposit" => null,
            "tax_note" => null,
            "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573",
            "province_id" => "bc24d551-7dcb-42e7-acf5-b72e0a22a7b7",
            "district_id" => $districtId,
            "commune_id" => $communeId,
            "village" => 'test village',
            "street" => $this->faker->numberBetween(1, 300),
            "house" => $this->faker->numberBetween(1, 1000),
            "cornered_with" => $this->faker->word(2),
            "street_view_link" => null,
            "lat_lng" => $this->faker->latitude(11.2, 11.9) . ',' . $this->faker->longitude(104, 105.1),
            "direction" => $this->faker->randomElement((array_column(Direction::cases(), 'value'))),
            "road_condition" => $this->faker->randomElement((array_column(RoadCondition::cases(), 'value'))),
            "direct_road_width" => null,
            "land_width" => $width,
            "land_length" => $length,
            "land_size" => $width * $length,
            "land_size_unit" => LengthUnit::SQUARE_METER,
            "land_shape" => $this->faker->randomElement((array_column(LandShape::cases(), 'value'))),
            "zoning" => null,
            "topography" => null,
            "sewerage" => null,
            "drainage" => null,
            "location_appeal" => null,
            "current_used" => null,
            "surrounding_land_used" => null,
            "building_width" => null,
            "building_length" => null,
            "number_of_stories" => null,
            "gross_building_area_size" => null,
            "warehouse_area_size" => null,
            "office_area_size" => null,
            "clear_height" => null,
            "available_floor" => null,
            "floor_load_capacity" => null,
            "each_floor_size" => null,
            "building_main_wall" => null,
            "ceiling" => null,
            "flooring_material" => null,
            "roofing" => null,
            "window_frame" => null,
            "design_appeal" => null,
            "year_of_construction" => null,
            "estimated_years_usable" => null,
            "actual_age" => null,
            "effective_age" => null,
            "estimated_cost" => null,
            "number_of_mezzanines" => $this->faker->numberBetween(1, 5),
            "number_of_bedrooms" => $this->faker->numberBetween(1, 5),
            "number_of_bathrooms" => $this->faker->numberBetween(1, 5),
            "stock_value" => null,
            "fixture_value" => null,
            "sale_revenue" => null,
            "number_of_employees" => null,
            "trading_hours" => null,
            "expansion_potential" => null,
            "year_establish" => null,
            "selling_reason" => null,
            "electricity_supply" => null,
            "water_supply" => null,
            "published" =>  $this->faker->randomElement([true, false]),
            "published_on_website" => $this->faker->randomElement([true, false]),
            "featured" => $this->faker->randomElement([true, false]),
            "show_map" => $this->faker->randomElement([true, false]),
            "special" => $this->faker->randomElement([true, false]),
            "exclusive" => $this->faker->randomElement([true, false]),
            "recommended" => $this->faker->randomElement([true, false]),
            "description" => $this->faker->paragraph(2),
            "form_layout" => $this->faker->randomElement((array_column(FormLayout::cases(), 'value'))),
            "assignee_id" => $assigneeId,
            "assignor_id" => $superAdminId,
            "created_by" => $superAdminId,
            "created_at" => Carbon::today()->subDays(rand(0, 90))
        ];
    }
}
