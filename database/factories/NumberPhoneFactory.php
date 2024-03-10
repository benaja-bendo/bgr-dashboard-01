<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NumberPhone>
 */
class NumberPhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'number_phone' => fake()->phoneNumber,
            'type' => fake()->randomElement(['home', 'work', 'mobile']),
            'is_default' => fake()->boolean,
            'country_code' => fake()->countryCode,
            'area_code' => fake()->areaCode,
        ];
    }
}
