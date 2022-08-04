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
        Schema::create('user_levels', function (Blueprint $table) {
            $table->uuid("team_id")->nullable();
            $table->foreign('team_id')->references('id')->on('user_teams');

            $table->uuid("user_id")->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedTinyInteger('level')->default(1);

            $table->unique(['team_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_levels');
    }
};
