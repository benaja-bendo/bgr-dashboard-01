<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AddresseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->sentence,
            'city' => $this->faker->city,
            'zipcode' => $this->faker->postcode,
            'country' => $this->faker->country,
        ];
    }
}
