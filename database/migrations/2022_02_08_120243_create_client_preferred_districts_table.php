<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateClientPreferredDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('client_preferred_districts', function (Blueprint $table) {
            $table->uuid('client_requirement_id');
            $table->foreign('client_requirement_id')->references('id')->on('client_requirements');

            $table->uuid('district_id');
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('client_preferred_districts');
    }
}
