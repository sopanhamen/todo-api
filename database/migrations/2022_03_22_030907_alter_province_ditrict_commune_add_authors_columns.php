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
        Schema::connection()->table('provinces', function (Blueprint $table) {
            $table->authors();
        });
        Schema::connection()->table('districts', function (Blueprint $table) {
            $table->authors();
        });
        Schema::connection()->table('communes', function (Blueprint $table) {
            $table->authors();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->table('provinces', function (Blueprint $table) {
            $table->dropAuthors();
        });

        Schema::connection()->table('districts', function (Blueprint $table) {
            $table->dropAuthors();
        });

        Schema::connection()->table('communes', function (Blueprint $table) {
            $table->dropAuthors();
        });
    }
};
