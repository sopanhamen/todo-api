<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->table('properties', function (Blueprint $table) {
            $table->renameColumn('evaluation_report_number', 'valuation_report_number');
        });

        Schema::connection()->table('property_histories', function (Blueprint $table) {
            $table->renameColumn('evaluation_report_number', 'valuation_report_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->table('properties', function (Blueprint $table) {
            $table->renameColumn('valuation_report_number', 'evaluation_report_number');
        });
        Schema::connection()->table('property_histories', function (Blueprint $table) {
            $table->renameColumn('valuation_report_number', 'evaluation_report_number');
        });
    }
};