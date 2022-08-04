<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('property_code_prefix_unlisting')
                ->default(config('company.default_property_code_prefix_unlisting'));

            $table->unsignedInteger('property_code_digit_unlisting')
                ->default(config('company.default_property_code_digit_unlisting'));
        });

        DB::statement("UPDATE companies SET property_code_prefix_unlisting = ?, property_code_digit_unlisting = ?", [
            config('company.default_property_code_prefix_unlisting'),
            config('company.default_property_code_digit_unlisting'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('property_code_prefix_unlisting');
            $table->dropColumn('property_code_digit_unlisting');
        });
    }
};
