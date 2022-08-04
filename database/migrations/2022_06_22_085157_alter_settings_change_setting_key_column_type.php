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
        Schema::table('settings', function (Blueprint $table) {
            $table->dropPrimary('setting_key');
            $table->renameColumn('setting_key', 'setting_key_old');
            $table->uuid('id')->nullable();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('setting_key')->nullable();
        });

        DB::statement('UPDATE settings SET id = gen_random_uuid(), setting_key = setting_key_old');

        Schema::table('settings', function (Blueprint $table) {
            $table->uuid('id')->primary()->change();
            $table->string('setting_key')->unique()->change();
            $table->dropColumn('setting_key_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('setting_key')->primary()->change();
        });
    }
};
