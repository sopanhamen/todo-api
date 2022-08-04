<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateClientPreferredProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('client_preferred_provinces', function (Blueprint $table) {
            $table->uuid('client_requirement_id');
            $table->foreign('client_requirement_id')->references('id')->on('client_requirements');

            $table->uuid('province_id');
            $table->foreign('province_id')->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('client_preferred_provinces');
    }
}
