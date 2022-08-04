<?php

use App\Modules\Property\Enum\Purpose;
use App\Modules\Common\Enum\DeedType;
use App\Modules\Common\Enum\DataSource;
use App\Modules\Common\Enum\Direction;
use App\Modules\Common\Enum\RoadCondition;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Common\Enum\Person;
use App\Modules\Common\Enum\LengthUnit;
use App\Modules\Common\Enum\LandShape;
use App\Modules\Common\Enum\Zoning;
use App\Modules\Common\Enum\Topography;
use App\Modules\Common\Enum\Sewerage;
use App\Modules\Common\Enum\Drainage;
use App\Modules\Common\Enum\LocationAppeal;
use App\Modules\Common\Enum\Ceiling;
use App\Modules\Common\Enum\FlooringMaterial;
use App\Modules\Common\Enum\Roofing;
use App\Modules\Common\Enum\WindowFrame;
use App\Modules\Common\Enum\DesignAppeal;
use App\Modules\Property\Enum\ListingStatus;
use App\Modules\Property\Enum\ElectricitySupply;
use App\Modules\Property\Enum\WaterSupply;
use App\Modules\Property\Enum\WallMaterial;
use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use App\Modules\Common\Enum\FormLayout;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Property basic Info
            $table->string('code')->unique();

            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->uuid('company_branch_id');
            $table->foreign('company_branch_id')->references('id')->on('company_branches');

            $table->uuid('team_id');
            $table->foreign('team_id')->references('id')->on('user_teams');

            $table->unsignedInteger('property_type_id');
            $table->foreign('property_type_id')->references('id')->on('property_types');

            $table->unsignedInteger('developer_id')->nullable();
            $table->foreign('developer_id')->references('id')->on('developers');

            $table->uuid('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');

            $table->enum('listing_purpose', array_column(Purpose::cases(), 'value'));
            $table->enum('title_deed_type', array_column(DeedType::cases(), 'value'))->nullable();
            $table->string('title_deed_number')->nullable();
            $table->enum('data_source', array_column(DataSource::cases(), 'value'))->nullable();
            $table->string('evaluation_report_number')->nullable();

            // Listing info
            $table->date('listing_date');
            $table->date('expired_listing_date');
            $table->enum('listing_status', array_column(ListingStatus::cases(), 'value'));
            $table->decimal('selling_price', 19, 2)->nullable();
            $table->enum('selling_price_type', array_column(PriceType::cases(), 'value'))->nullable();
            $table->decimal('renting_price', 19, 2)->nullable();
            $table->enum('renting_price_type', array_column(PriceType::cases(), 'value'))->nullable();

            // Contact & Sale info
            $table->uuid('owner_contact_id')->nullable();
            $table->foreign('owner_contact_id')->references('id')->on('contacts');

            $table->uuid('sale_contact_id')->nullable();
            $table->foreign('sale_contact_id')->references('id')->on('contacts');

            $table->enum('sale_contact_person', array_column(Person::cases(), 'value'))->nullable();
            $table->text('sale_note')->nullable();
            $table->year('renting_terms')->nullable()->comment('Number of years that client rent a property');
            $table->float('renting_deposit')->nullable()->comment('Number of months deposit for rent');
            $table->text('tax_note')->nullable();

            // Property Location
            $table->uuid('country_id');
            $table->foreign('country_id')->references('id')->on('countries');

            $table->uuid('province_id');
            $table->foreign('province_id')->references('id')->on('provinces');

            $table->uuid('district_id');
            $table->foreign('district_id')->references('id')->on('districts');

            $table->uuid('commune_id');
            $table->foreign('commune_id')->references('id')->on('communes');

            $table->string('village')->nullable();
            $table->string('street')->nullable();
            $table->string('house')->nullable();
            $table->string('cornered_with')->nullable();
            $table->string('street_view_link')->nullable();
            $table->string('lat_lng')->nullable();
            $table->enum('direction', array_column(Direction::cases(), 'value'))->nullable();
            $table->enum('road_condition', array_column(RoadCondition::cases(), 'value'))->nullable();
            $table->float('direct_road_width')->nullable();

            // Land info
            $table->double('land_width')->nullable(); // meter
            $table->double('land_length')->nullable(); // meter
            $table->double('land_size')->nullable(); // length unit based on land_size_unit
            $table->enum('land_size_unit', array_column(LengthUnit::cases(), 'value'))->nullable();
            $table->enum('land_shape', array_column(LandShape::cases(), 'value'))->nullable();
            $table->enum('zoning', array_column(Zoning::cases(), 'value'))->nullable();
            $table->enum('topography', array_column(Topography::cases(), 'value'))->nullable();
            $table->enum('sewerage', array_column(Sewerage::cases(), 'value'))->nullable();
            $table->enum('drainage', array_column(Drainage::cases(), 'value'))->nullable();
            $table->enum('location_appeal', array_column(LocationAppeal::cases(), 'value'))->nullable();
            $table->text('current_used')->nullable();
            $table->text('surrounding_land_used')->nullable();

            // Building Info
            $table->double('building_width')->nullable();
            $table->double('building_length')->nullable();
            $table->float('number_of_stories')->nullable();
            $table->double('gross_building_area_size')->nullable();
            $table->double('warehouse_area_size')->nullable();
            $table->double('office_area_size')->nullable();
            $table->double('clear_height')->nullable();
            $table->float('available_floor')->nullable();
            $table->double('floor_load_capacity')->nullable();
            $table->double('each_floor_size')->nullable();
            $table->enum('building_main_wall', array_column(WallMaterial::cases(), 'value'))->nullable();
            $table->enum('ceiling', array_column(Ceiling::cases(), 'value'))->nullable();
            $table->enum('flooring_material', array_column(FlooringMaterial::cases(), 'value'))->nullable();
            $table->enum('roofing', array_column(Roofing::cases(), 'value'))->nullable();
            $table->enum('window_frame', array_column(WindowFrame::cases(), 'value'))->nullable();
            $table->enum('design_appeal', array_column(DesignAppeal::cases(), 'value'))->nullable();
            $table->year('year_of_construction')->nullable();
            $table->year('estimated_years_usable')->nullable(); // changed from Estimate useful life
            $table->year('actual_age')->nullable();
            $table->year('effective_age')->nullable();
            $table->decimal('estimated_cost', 19, 2)->nullable();
            $table->float('number_of_mezzanines')->nullable();
            $table->float('number_of_bedrooms')->nullable();
            $table->float('number_of_bathrooms')->nullable();

            // Business information
            $table->double('stock_value')->nullable();
            $table->double('fixture_value')->nullable();
            $table->decimal('sale_revenue', 19, 2)->nullable();
            $table->double('number_of_employees')->nullable();
            $table->float('trading_hours')->nullable();
            $table->float('expansion_potential')->nullable();
            $table->year('year_establish')->nullable();
            $table->string('selling_reason')->nullable();

            // Facilities info
            $table->enum('electricity_supply', array_column(ElectricitySupply::cases(), 'value'))->nullable();
            $table->enum('water_supply', array_column(WaterSupply::cases(), 'value'))->nullable();

            // Publish/Display options
            $table->boolean('published')->default(true);
            $table->boolean('published_on_website')->default(true);
            $table->boolean('featured')->default(false);
            $table->boolean('special')->default(false);
            $table->boolean('exclusive')->default(false);
            $table->boolean('recommended')->default(false);
            $table->text('description')->nullable();
            $table->enum('form_layout', array_column(FormLayout::cases(), 'value'));

            // Log info
            $table->uuid('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users');

            $table->uuid('assignor_id')->nullable();
            $table->foreign('assignor_id')->references('id')->on('users');

            $table->authors();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('properties');
    }
}
