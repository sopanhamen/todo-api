<?php

namespace Database\Seeders;

use App\Modules\Client\Client;
use App\Modules\ClientType\ClientType;
use Illuminate\Database\Seeder;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id" => "3b9e426a-ed40-47b6-8cc1-21b3490d152f", "name" => "Banks", "published" => true, 'created_at' => now()],
            ["id" => "8cf8eacf-47a9-4292-af71-2c77a85754a4", "name" => "Property Owner", "published" => true, 'created_at' => now()],
            ["id" => "885e1d4d-14c1-41ad-919d-d0c8815dd7ba", "name" => "Call-in", "published" => true, 'created_at' => now()],
            ["id" => "39b186be-f7f0-424c-9c3e-80e3d56187a0", "name" => "Buyer", "published" => true, 'created_at' => now()],
            ["id" => "e41c90de-bfdb-4942-9518-9215644508a0", "name" => "Walk-in", "published" => true, 'created_at' => now()],
        ];

        ClientType::insert($data);
    }
}
