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
        Schema::table('bank_branches', function (Blueprint $table) {
            $table->dropForeign('bank_branches_bank_id_foreign');
            $table->dropColumn('bank_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_branches', function (Blueprint $table) {
            $table->integer('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }
};
