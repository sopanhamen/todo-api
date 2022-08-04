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
        Schema::connection()->create('payment_documents', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('client_payment_id');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('file_name');
            $table->string('storage_disk')->default('public');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_payment_id')->references('id')->on('client_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('payment_documents');
    }
};
