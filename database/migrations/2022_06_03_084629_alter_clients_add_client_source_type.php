<?php

use App\Modules\Client\Enum\ClientSource;
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
        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('source', 'source_old')->nullable()->change();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->enum('source', array_column(ClientSource::cases(), 'value'))->nullable();
        });

        DB::statement('UPDATE clients SET source = source_old');

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('source_old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('source')->nullable()->change();
        });
    }
};
