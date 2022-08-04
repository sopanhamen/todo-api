<?php

use App\Modules\Client\Enum\VisitingStatus;
use Illuminate\Database\Migrations\Migration;
use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('property_visits', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('client_requirement_id');
            $table->uuid('property_id');
            $table->uuid('person_in_charge_id')->comment('Agent id. (can be agent, team leader, ...');

            $table->timestamp('visited_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->enum('status', array_column(VisitingStatus::cases(), 'value'))
                ->comment('
                    - Canceled: agent/owner/client not available and requested to meet up another day (will remark in note).
                    - Visited: successfully meet up.
                    - Deleted: Soft delete (mistake by user entry).
                ');
            $table->text('note')->nullable();
            $table->authors();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_requirement_id')->references('id')->on('client_requirements');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('person_in_charge_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('property_visits');
    }
};
