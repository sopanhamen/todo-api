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
            DB::statement("
                ALTER TABLE properties
                ALTER COLUMN listing_date TYPE TIMESTAMP,
                ALTER COLUMN expired_listing_date TYPE TIMESTAMP
            ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE properties 
                ALTER COLUMN listing_date TYPE DATE,
                ALTER COLUMN expired_listing_date TYPE DATE
            ");
        });
    }
};
