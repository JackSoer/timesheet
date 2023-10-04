<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkLog>
 */
class WorkLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'developer_id' => fake()->randomElement([1, 2]),
            'project_id' => fake()->randomElement([1, 2]),
            'rate' => fake()->randomNumber(2),
            'hrs' => fake()->randomNumber(2),
            'total' => fake()->randomNumber(2),
            'status' => fake()->randomElement([100, 200]),
        ];
    }
}
