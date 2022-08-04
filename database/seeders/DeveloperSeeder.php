<?php

namespace Database\Seeders;

use App\Modules\Developer\Developer;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "Borey Peng Hout",
                "development_type_id" => 3,
                "primary_phone" => "011234234",
                "published" => true
            ],
            [
                "name" => "Borey Varina",
                "development_type_id" => 3,
                "primary_phone" => "011234234",
                "published" => true
            ],
            [
                "name" => "Borey Varina Phnom Penh",
                "development_type_id" => 3,
                "primary_phone" => "011234234",
                "published" => true
            ],
            [
                "name" => "Sen Sok Apartment",
                "development_type_id" => 2,
                "primary_phone" => "011234234",
                "published" => true
            ],
            [
                "name" => "Toul Kok Condo",
                "development_type_id" => 4,
                "primary_phone" => "011234234",
                "published" => true
            ],
            [
                "name" => "Parama Office Space",
                "development_type_id" => 5,
                "primary_phone" => "011234234",
                "published" => true
            ],
            [
                "name" => "Camco City",
                "development_type_id" => 1,
                "primary_phone" => "011234234",
                "published" => true
            ],
        ];

        Developer::insert($data);
    }
}
