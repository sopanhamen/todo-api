<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateClientPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('client_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('client_requirement_id');
            $table->uuid('property_id');
            $table->uuid('owner_contact_id')->comment('In case property has changed owner in someday, we can check history.');
            $table->uuid('person_in_charge_id')->comment('Agent id. (can be agent, team leader, ...)');

            $table->decimal('amount', 19, 2);
            $table->text('note')->nullable();
            $table->timestamp('payment_date');
            $table->timestamp('next_payment_date')->nullable();

            $table->authors();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_requirement_id')->references('id')->on('client_requirements');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('owner_contact_id')->references('id')->on('contacts');
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
        Schema::connection()->dropIfExists('client_payments');
    }
}
