<?php

namespace Database\Factories\Modules\Client;

use App\Modules\Client\Client;
use App\Modules\Client\Enum\ClientSource;
use App\Modules\Common\Enum\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "id" => $this->faker->uuid(),
            "first_name" => $this->faker->firstName(),
            "last_name" => $this->faker->lastName(),
            "client_type_id" => 'e41c90de-bfdb-4942-9518-9215644508a0',
            "published" => true,
            "phone" => $this->faker->numerify('+855#########'),
            "gender" => Gender::NOT_SPECIFIED,
            "source" => ClientSource::THIRD_PARTY,
        ];
    }
}
