<?php

namespace Database\Seeders;

use App\Modules\DevelopmentType\DevelopmentType;
use Illuminate\Database\Seeder;

class DevelopmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["name" => "Satellite Cities", "published" => true, "created_at" => now()],
            ["name" => "Apartment Project", "published" => true, "created_at" => now()],
            ["name" => "Condo Project", "published" => true, "created_at" => now()],
            ["name" => "Gate Communities", "published" => true, "created_at" => now()],
            ["name" => "Office Space Project", "published" => true, "created_at" => now()],
        ];

        DevelopmentType::insert($data);
    }
}
