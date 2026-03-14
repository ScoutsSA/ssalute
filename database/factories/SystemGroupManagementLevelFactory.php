<?php

namespace Database\Factories;

use App\Models\SystemGroupManagementLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemGroupManagementLevel> */
class SystemGroupManagementLevelFactory extends Factory
{
    protected $model = SystemGroupManagementLevel::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'type' => fake()->word(),
            'description' => fake()->sentence(),
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
