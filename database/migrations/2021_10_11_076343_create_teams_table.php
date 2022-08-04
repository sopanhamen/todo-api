<?php

use Illuminate\Database\Migrations\Migration;
use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('user_teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_branch_id');
            $table->string('name');
            $table->boolean('published')->default(false);
            $table->authors();
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
        Schema::connection()->dropIfExists('user_teams');
    }
};
