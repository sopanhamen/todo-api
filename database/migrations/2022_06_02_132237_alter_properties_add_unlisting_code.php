<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('unlisting_code')->uniqid()->nullable();
        });

        Schema::table('property_histories', function (Blueprint $table) {
            $table->string('unlisting_code')->uniqid()->nullable();
        });

        DB::statement('UPDATE properties SET unlisting_code = code');
        DB::statement('UPDATE property_histories SET unlisting_code = code');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('unlisting_code');
        });

        Schema::table('property_histories', function (Blueprint $table) {
            $table->dropColumn('unlisting_code');
        });
    }
};
