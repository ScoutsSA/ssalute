<?php

namespace Database\Factories;

use App\Models\SystemAdvancementRoversLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementRoversLevel> */
class SystemAdvancementRoversLevelFactory extends Factory
{
    protected $model = SystemAdvancementRoversLevel::class;

    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 100),
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'htmlColor' => fake()->safeColorName(),
            'active' => 1,
        ];
    }
}
