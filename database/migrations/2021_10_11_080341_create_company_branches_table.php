<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('company_branches', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->string('name');
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('email');
            $table->string('website')->nullable();

            $table->string('lat_lng')->nullable();
            $table->uuid('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->uuid('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->uuid('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->uuid('commune_id')->nullable();
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->string('street')->nullable();

            $table->boolean('published')->default(false);
            $table->boolean('defaulted')->default(false);
            $table->authors();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('company_branches');
    }
};
