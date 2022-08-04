<?php

use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use App\Modules\Common\Enum\Gender;
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
        Schema::connection()->create('contacts', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();

            // Basic info
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('primary_phone')->unique();
            $table->string('secondary_phone')->nullable();

            // Address and location
            $table->uuid('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->uuid('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces');

            $table->uuid('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts');

            $table->uuid('commune_id')->nullable();
            $table->foreign('commune_id')->references('id')->on('communes');


            $table->string('address')->nullable();
            $table->string('street')->nullable();
            $table->string('house')->nullable();

            // Legal information
            $table->enum("gender", array_column(Gender::cases(), 'value'))->nullable();
            $table->string('national_id_number')->nullable();
            $table->string('national_id_image_front')->nullable();
            $table->string('national_id_image_back')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_id_image_front')->nullable();
            $table->string('passport_id_image_back')->nullable();

            // Socials
            $table->string("telegram")->nullable();
            $table->string("line")->nullable();
            $table->string("wechat")->nullable();
            $table->string("facebook")->nullable();
            $table->string("linkedin")->nullable();
            $table->string("instagram")->nullable();
            $table->string("youtube")->nullable();
            $table->string("tiktok")->nullable();

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
        Schema::connection()->dropIfExists('contacts');
    }
};
