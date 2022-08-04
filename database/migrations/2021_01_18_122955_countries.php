<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use Illuminate\Database\Migrations\Migration;

class Countries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name");
            $table->string("name_km")->nullable();
            $table->string("iso_code"); // see https://www.att.com/support_media/images/pdf/Country_Code_List.pdf
            $table->string("code")->nullable();
            $table->text("boundary")->nullable();
            $table->boolean("published")->default(false);
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
        Schema::connection()->dropIfExists('countries');
    }
}
