<?php

namespace Database\Factories;

use App\Models\SystemAdvancementMeerkatsLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementMeerkatsLevel> */
class SystemAdvancementMeerkatsLevelFactory extends Factory
{
    protected $model = SystemAdvancementMeerkatsLevel::class;

    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 100),
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'active' => 1,
        ];
    }
}
