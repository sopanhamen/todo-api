<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
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
        Schema::dropIfExists('provinces');
    }
};
