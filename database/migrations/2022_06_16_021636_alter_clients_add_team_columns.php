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
        Schema::table('clients', function (Blueprint $table) {
            $table->uuid('company_id')->default('4f7e0ea0-5437-445f-a579-cd6bb90c98e0');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->uuid('company_branch_id')->nullable();
            $table->foreign('company_branch_id')->references('id')->on('company_branches');

            $table->uuid('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('user_teams');


            $table->uuid('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users');

            $table->uuid('assignor_id')->nullable();
            $table->foreign('assignor_id')->references('id')->on('users');
        });

        DB::statement('UPDATE clients SET assignee_id = created_by WHERE assignee_id IS null');
        DB::statement('UPDATE clients SET assignor_id = created_by WHERE assignor_id IS null');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('company_branch_id');
            $table->dropColumn('team_id');
            $table->dropColumn('assignee_id');
            $table->dropColumn('assignor_id');
        });
    }
};
