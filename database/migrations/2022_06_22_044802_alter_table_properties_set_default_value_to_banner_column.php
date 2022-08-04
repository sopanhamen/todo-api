<?php

use App\Modules\Common\Enum\Banner;
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
        Schema::table('properties', function (Blueprint $table) {
            $table->renameColumn('banner', 'banner_old');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->enum('banner', array_column(Banner::cases(), 'value'))
                ->default(Banner::NO_BANNER->value);
        });

        DB::statement('UPDATE properties SET banner = banner_old WHERE banner_old IS NOT NULL');

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('banner_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->renameColumn('banner', 'banner_old');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->enum('banner', array_column(Banner::cases(), 'value'))->nullable();
        });

        DB::statement('UPDATE properties SET banner = banner_old');

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('banner_old');
        });
    }
};
