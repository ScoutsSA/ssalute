<?php

namespace Database\Factories;

use App\Models\SystemAdvancementScoutsLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementScoutsLevel> */
class SystemAdvancementScoutsLevelFactory extends Factory
{
    protected $model = SystemAdvancementScoutsLevel::class;

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
