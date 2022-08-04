<?php

namespace Database\Seeders;

use App\Modules\Project\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
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
                'id' => '642ebbf4-9ec8-4ad1-98bc-b2d2dfbe05ee',
                "name" => "Peng Hout Boeng Snoar",
                "development_type_id" => 3,
                "developer_id" => 1,
                "primary_phone" => "012123123",
                "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573",
                "province_id" => "bc24d551-7dcb-42e7-acf5-b72e0a22a7b7",
                "district_id" => "c7579555-0732-44ab-81c4-0d8c998f558f",
                "commune_id" => "8d504b6f-8b9d-4fdd-a363-ac150a792763",
                "exclusive" => true,
                "published" => true
            ],
            [
                'id' => '4ead5bdb-4b73-48fc-bccc-154212337f7d',
                "name" => "Rose Condo - Toul Kork",
                "development_type_id" => 4,
                "developer_id" => 7,
                "primary_phone" => "012123123",
                "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573",
                "province_id" => "bc24d551-7dcb-42e7-acf5-b72e0a22a7b7",
                "district_id" => "c7579555-0732-44ab-81c4-0d8c998f558f",
                "commune_id" => "8d504b6f-8b9d-4fdd-a363-ac150a792763",
                "exclusive" => true,
                "published" => true
            ],
            [
                'id' => '63730155-a2b1-4654-a1c3-62151f51f2f4',
                "name" => "Unknown",
                "development_type_id" => 1,
                "developer_id" => 1,
                "primary_phone" => "012123123",
                "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573",
                "province_id" => "bc24d551-7dcb-42e7-acf5-b72e0a22a7b7",
                "district_id" => "c7579555-0732-44ab-81c4-0d8c998f558f",
                "commune_id" => "8d504b6f-8b9d-4fdd-a363-ac150a792763",
                "exclusive" => true,
                "published" => true
            ],
        ];

        Project::insert($data);
    }
}
