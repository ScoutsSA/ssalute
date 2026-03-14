<?php

namespace Database\Factories;

use App\Models\SystemAdvancementCubsLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementCubsLevel> */
class SystemAdvancementCubsLevelFactory extends Factory
{
    protected $model = SystemAdvancementCubsLevel::class;

    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 100),
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'colour' => fake()->safeColorName(),
            'active' => 1,
        ];
    }
}
