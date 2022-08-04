<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;


class Provinces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('provinces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('code')->unique();
            $table->string("name_km");
            $table->string("name_en");
            $table->uuid("country_id");
            $table->foreign('country_id')->references('id')->on('countries');
            $table->text("boundary")->nullable();
            $table->string('center')->nullable();
            $table->boolean("published")->default(false);
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
        Schema::connection()->dropIfExists('provinces');
    }
}
