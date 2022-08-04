<?php

use Illuminate\Database\Migrations\Migration;
use App\Libraries\Database\Blueprint;
use App\Libraries\Database\Schema;
use App\Modules\Common\Enum\Gender;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection()->create('user_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('contact_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('contacts');

            $table->uuid("user_id")->unique();
            $table->foreign('user_id')->references('id')->on('users');

            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies');

            $table->uuid("company_branch_id");
            $table->foreign('company_branch_id')->references('id')->on('company_branches');

            // Basic information
            $table->enum("gender", array_column(Gender::cases(), 'value'));
            $table->string("position")->nullable();
            $table->string("experience")->nullable();
            $table->string("skills")->nullable();

            // Sites setting
            $table->string("language")->default('en');
            $table->string("theme")->nullable();

            // Other
            $table->string("profile_picture")->nullable();
            $table->string('profile_picture_disk')->default('public');

            // Audit
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
        Schema::connection()->dropIfExists('user_profiles');
    }
}
