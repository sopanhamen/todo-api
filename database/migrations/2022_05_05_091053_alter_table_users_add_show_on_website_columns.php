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
        Schema::connection()->table('users', function (Blueprint $table) {
            $table->boolean('show_on_website')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->table('users', function (Blueprint $table) {
            $table->dropColumn('show_on_website');
        });
    }
};
