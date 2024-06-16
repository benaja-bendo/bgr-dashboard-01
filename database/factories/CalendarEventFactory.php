<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarEvent>
 */
class CalendarEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = now()->subDays(rand(1, 30));
        $end = $start->copy()->addHours(rand(1, 5));
        return [
            'title' => fake()->sentence,
            'start' => $start,
            'end' => $end,
            'description' => fake()->sentence,
            'user_id' => 1,
            'all_day' => fake()->boolean,
            'background_color' => fake()->hexColor,
            'text_color' => fake()->hexColor,
        ];
    }
}
