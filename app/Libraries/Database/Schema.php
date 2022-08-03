<?php

namespace App\Libraries\Database;

use App\Libraries\Database\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\PostgresBuilder;
use Illuminate\Support\Facades\DB;

class Schema
{
    /**
     * Get a schema builder instance for a connection.
     *
     * @param  string|null  $name
     * @return Builder|PostgresBuilder
     */
    public static function connection()
    {
        $schema = DB::connection()->getSchemaBuilder();
        $schema->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });

        return $schema;
    }
}
