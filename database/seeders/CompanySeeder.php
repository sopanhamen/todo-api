<?php

namespace Database\Seeders;

use App\Modules\Company\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "id" => "4f7e0ea0-5437-445f-a579-cd6bb90c98e0",
            "name" => "Great Deal Realty Co., Ltd.",
            "published" => true,
            "property_code_prefix" => 'GD-',
            "logo" => 'images/appa_logo.png',
            "vision" => "To be the number one real estate brokerage in Cambodia.",
            "mission" => "  - Using the brand to execute sales.
                            - Using the training program to develop a professional sale team.
                            - To create a commission structure that best supports the agents.",
            "primary_phone" => "+855012812218",
            "email" => "info@gd-realty.com",
            "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", // Cambodia
            "province_id" => "bc24d551-7dcb-42e7-acf5-b72e0a22a7b7", // Phnom Penh
            "district_id" => "8ca800bf-42b1-4c32-8c5a-fc532d39624c", // Sen Sok

            "created_at" => now()
        ];

        Company::create($data);
    }
}
