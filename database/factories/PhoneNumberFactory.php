<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhoneNumber>
 */
class PhoneNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->phoneNumber,
            'type' => $this->faker->randomElement(['fixe', 'mobile', 'fax', 'autre']),
            'country_code' => $this->faker->countryCode,
            'area_code' => $this->faker->areaCode,
        ];
    }
}
