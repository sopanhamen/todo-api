<?php

namespace Database\Factories\Modules\Company;

use App\Modules\Company\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class CompanyFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->company(),
            "published" => true,

            "vision" => "To be the number one real estate brokerage in Cambodia.",
            "mission" => "  - Using the brand to execute sales.
                            - Using the training program to develop a professional sale team.
                            - To create a commission structure that best supports the agents.",
            "primary_phone" => $this->faker->numerify('+855########'),
            "secondary_phone" => $this->faker->numerify('+855########'),
            "email" => $this->faker->unique()->safeEmail(),
            "created_at" => now()
        ];
    }
}
