<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class Communes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('communes', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->unsignedBigInteger('code')->unique();
            $table->string("name_km");
            $table->string("name_en");
            $table->uuid("district_id");
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->text("boundary")->nullable();
            $table->string("center")->nullable();
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
        Schema::connection()->dropIfExists('communes');
    }
}
