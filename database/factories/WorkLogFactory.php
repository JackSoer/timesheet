<?php

namespace Database\Factories;

use App\Models\Developer;
use App\Models\Project;
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
            'developer_id' => Developer::factory(),
            'project_id' => Project::factory(),
            'rate' => fake()->randomNumber(2),
            'date' => fake()->date(),
            'hrs' => fake()->randomNumber(2),
            'total' => fake()->randomNumber(2),
            'status' => fake()->randomElement([100, 200]),
        ];
    }
}
