<?php

use Illuminate\Database\Migrations\Migration;
use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->unsignedInteger('development_type_id');
            $table->unsignedInteger('developer_id');

            $table->integer('total_floor')->nullable();
            $table->integer('total_unit')->nullable();
            $table->double('total_one_bedroom', 8, 2)->nullable();
            $table->double('one_bedroom_size', 8, 2)->nullable();
            $table->double('one_bedroom_size_to', 8, 2)->nullable();
            $table->double('total_two_bedroom', 8, 2)->nullable();
            $table->double('two_bedroom_size', 8, 2)->nullable();
            $table->double('two_bedroom_size_to', 8, 2)->nullable();
            $table->double('total_three_bedroom', 8, 2)->nullable();
            $table->double('three_bedroom_size', 8, 2)->nullable();
            $table->double('three_bedroom_size_to', 8, 2)->nullable();
            $table->double('pent_house_size', 8, 2)->nullable();
            $table->string('primary_phone');
            $table->string('secondary_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();

            $table->uuid('country_id');
            $table->uuid('province_id');
            $table->uuid('district_id');
            $table->uuid('commune_id');
            $table->string('village')->nullable();
            $table->string('street_no')->nullable();
            $table->string('building_no')->nullable();
            $table->integer('direction')->nullable();
            $table->integer('road_con')->nullable();
            $table->double('road_dir_width', 8, 2)->nullable();
            $table->string('lat_lng')->nullable();

            $table->string('image_one')->nullable();
            $table->string('image_two')->nullable();
            $table->string('image_three')->nullable();
            $table->string('image_four')->nullable();
            $table->string('image_five')->nullable();
            $table->boolean('published')->default(false);
            $table->boolean('exclusive')->default(false);
            $table->authors();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('developer_id')->references('id')->on('developers');
            $table->foreign('development_type_id')->references('id')->on('development_types');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('commune_id')->references('id')->on('communes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('projects');
    }
}
