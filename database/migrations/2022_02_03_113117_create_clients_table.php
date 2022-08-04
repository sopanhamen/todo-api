<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use App\Modules\Common\Enum\Gender;
use App\Modules\Client\Enum\ClientSource;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("client_type_id");
            $table->foreign('client_type_id')->references('id')->on('client_types');

            // Registration info
            $table->boolean("published")->default(true);
            $table->enum("source", array_column(ClientSource::cases(), 'value'));

            // Profile
            $table->string("profile_picture")->nullable();

            // Contacts
            $table->uuid('client_contact_id')->unique();
            $table->foreign('client_contact_id')->references('id')->on('contacts');

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
        Schema::connection()->dropIfExists('clients');
    }
}
