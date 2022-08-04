<?php

namespace Database\Seeders;

use App\Modules\Country\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();

        $data = [
            [
                'id' => 'bff6ddbf-2a3f-477a-bb44-8d0b42212573',
                'name' => 'Cambodia',
                'iso_code' => 'KH',
                'code' => '855',
                'created_at' => now()
            ]
        ];

        Country::insert($data);
    }
}
