<?php

use Illuminate\Database\Migrations\Migration;
use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->year('year_established')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('key_value')->nullable();
            $table->string('address')->nullable();
            $table->string('primary_phone');
            $table->string('secondary_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_disk')->default('public');
            $table->boolean('published')->default(false);
            $table->string('property_code_prefix', 15)->default('CODE-');
            $table->unsignedSmallInteger('property_code_digit')->default(8); // Number of digit for property code

            $table->string('lat_lng')->nullable();
            $table->uuid('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->uuid('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->uuid('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->uuid('commune_id')->nullable();
            $table->foreign('commune_id')->references('id')->on('communes');

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
        Schema::connection()->dropIfExists('companies');
    }
}
