<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Common\Enum\Priority;
use App\Modules\ClientRequirement\Enum\Result;
use App\Modules\ClientRequirement\Enum\Service;
use Illuminate\Database\Migrations\Migration;

class CreateClientRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('client_requirements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->foreign('client_id')->references('id')->on('clients');

            $table->uuid('property_id')->nullable()->comment('Property that client and property owner agreed');
            $table->foreign('property_id')->references('id')->on('properties');

            $table->uuid('property_history_id')->nullable()->comment('To keep old information, we keep old data in property_histories');
            $table->foreign('property_history_id')->references('id')->on('property_histories');

            $table->string('code');
            $table->decimal('budget_min', 19, 2)->nullable();
            $table->decimal('budget_max', 19, 2)->nullable();
            $table->enum("service", array_column(Service::cases(), 'value'));
            $table->enum("price_type", array_column(PriceType::cases(), 'value'));
            $table->enum("priority", array_column(Priority::cases(), 'value'));
            $table->enum("result", array_column(Result::cases(), 'value'));
            $table->string("purpose")->nullable();
            $table->text('note')->nullable();
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
        Schema::connection()->dropIfExists('client_requirements');
    }
}
