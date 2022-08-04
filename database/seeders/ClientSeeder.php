<?php

namespace Database\Seeders;

use App\Modules\Client\Client;
use App\Modules\ClientRequirement\Enum\Result;
use App\Modules\ClientRequirement\Enum\Service;
use App\Modules\Common\Enum\PriceType;
use App\Modules\Common\Enum\Priority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purposes = [1 => "Sell house", 2 => "Buy house"];

        $clients = Client::factory()->count(10)->create();
        foreach ($clients as $client) {
            $rand = rand(0, 4);

            for ($i = 0; $i < $rand; $i++) {
                $requirement = $client->requirements()->create([
                    'id' => Str::uuid(),
                    "client_id" => $client->id,
                    "budget_min" => 10000,
                    "budget_max" => 12000,
                    "service" => Service::SELL,
                    "price_type" => PriceType::TOTAL,
                    "priority" => Priority::VERY_HIGH,
                    "result" => Result::IN_PROGRESS,
                    "purpose" => $purposes[rand(1, 2)],
                    "note" => null,
                ]);

                $requirement->preferredPropertyTypes()->sync([2, 3]);
                $requirement->preferredProjects()->sync([2, 3]);
                $requirement->preferredDevelopers()->sync([2, 3]);
                $requirement->preferredCountries()->sync([1]);
                $requirement->preferredProvinces()->sync([2, 3]);
                $requirement->preferredDistricts()->sync([203, 313]);
                $requirement->preferredCommunes()->sync(['46b056b3-bac2-4e65-8539-bc5c581edfa7']);
            }
        }
    }
}
