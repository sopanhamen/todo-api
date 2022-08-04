<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateBankBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('bank_branches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bank_id');
            $table->string('branch_name');
            $table->string('primary_phone');
            $table->string('secondary_phone')->nullable();
            $table->string('third_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();

            $table->uuid('country_id')->nullable();
            $table->uuid('province_id')->nullable();
            $table->uuid('district_id')->nullable();
            $table->uuid('commune_id')->nullable();
            $table->string('village')->nullable();
            $table->string('street')->nullable();
            $table->string('house')->nullable();
            $table->integer('office_type',)->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();

            // TODO: Check what are these columns?
            // $table->integer('valuer')->nullable();
            // $table->integer('ins_type');

            $table->string('lat_lng')->nullable();
            $table->boolean('published')->default(false);
            $table->authors();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::connection()->dropIfExists('bank_branches');
    }
}
