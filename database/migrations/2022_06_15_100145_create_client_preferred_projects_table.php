<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateClientPreferredProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('client_preferred_projects', function (Blueprint $table) {
            $table->uuid('client_requirement_id');
            $table->uuid('project_id');

            $table->unique(['client_requirement_id', 'project_id']);

            $table->foreign('project_id')->references('id')->on('projects');
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
        Schema::connection()->dropIfExists('client_preferred_projects');
    }
}