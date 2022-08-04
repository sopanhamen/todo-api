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
        Schema::table('property_histories', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE property_histories
                ALTER COLUMN listing_date TYPE TIMESTAMP
            ");

            $table->timestamp('expired_listing_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_histories', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE property_histories 
                ALTER COLUMN listing_date TYPE DATE
            ");

            $table->dropColumn('expired_listing_date');
        });
    }
};
