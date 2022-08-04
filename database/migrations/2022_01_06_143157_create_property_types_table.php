<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use App\Modules\Common\Enum\PropertyTypeGroup;
use Illuminate\Database\Migrations\Migration;


class CreatePropertyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('property_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('development_type_id')->nullable();
            $table->boolean('published')->default(false);

            $table->enum("property_type_group", array_column(PropertyTypeGroup::cases(), 'value'));

            $table->authors();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('development_type_id')->references('id')->on('development_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->dropIfExists('property_types');
    }
}
