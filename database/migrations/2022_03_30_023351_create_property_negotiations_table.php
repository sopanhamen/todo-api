<?php

use App\Modules\Client\Enum\NegotiationStatus;
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
        Schema::connection()->create('property_negotiations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('client_requirement_id');
            $table->uuid('property_id');
            $table->uuid('owner_contact_id')
                ->comment('In case property has changed owner in someday, we can check history.');
            $table->uuid('person_in_charge_id')
                ->comment('Agent id. (can be agent, team leader, ...');

            $table->decimal('last_buyer_price', 19, 2);
            $table->decimal('last_owner_price', 19, 2);
            $table->decimal('last_agreed_price', 19, 2)->nullable()
                ->comment('Should not be null when status is `Agreed`');

            $table->timestamp('negotiated_at');
            $table->enum('status', array_column(NegotiationStatus::cases(), 'value'))
                ->comment("
                    - Agreed: Ready for Payment step.
                    - Pending: Under consideration.
                    - Disagreed: Buyer/Owner confirmed disagreed with negotiated price.
                    - Canceled: Auto set to 'Canceled' when one property's negotiation is Agreed.
                ");
            $table->text('note')->nullable();
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
        Schema::connection()->dropIfExists('property_negotiations');
    }
};
