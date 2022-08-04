<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('property_documents', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('property_id');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('file_name');
            $table->string('storage_disk')->default('public');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('property_documents');
    }
}
