<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateClientPreferredDevelopersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('client_preferred_developers', function (Blueprint $table) {
            $table->uuid('client_requirement_id');
            $table->unsignedInteger('developer_id');

            $table->unique(['client_requirement_id', 'developer_id']);

            $table->foreign('developer_id')->references('id')->on('developers');
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
        Schema::connection()->dropIfExists('client_preferred_developers');
    }
}