<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateClientPreferredPropertyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('client_preferred_property_types', function (Blueprint $table) {
            $table->uuid('client_requirement_id');
            $table->unsignedInteger('property_type_id');

            $table->unique(['client_requirement_id', 'property_type_id']);

            $table->foreign('property_type_id')->references('id')->on('property_types');
            $table->foreign('client_requirement_id')->references('id')->on('client_requirements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('client_preferred_property_types');
    }
}
