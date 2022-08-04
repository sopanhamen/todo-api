<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateDevelopmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('development_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('published')->default(false);
            $table->authors();
            $table->timestamps();
            $table->softDeletes();

            // TODO: Check what is it used for?
            // $table->string('pin',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('development_types');
    }
}
