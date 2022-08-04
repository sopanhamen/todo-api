<?php

use App\Libraries\Database\Schema;
use App\Modules\Common\Enum\Banner;
use App\Libraries\Database\Blueprint;
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
        Schema::connection()->table('properties', function (Blueprint $table) {
            $table->enum('banner', array_column(Banner::cases(), 'value'))->nullable();
            $table->double('commission')->nullable()->after('tax_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection()->table('properties', function (Blueprint $table) {
            $table->dropColumn('banner');
            $table->dropColumn('commission');
        });
    }
};