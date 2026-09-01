<?php

namespace Database\Factories;

use App\Models\SystemAdvancementRoversLevel;
use App\Models\SystemAdvancementRoversSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementRoversSecond> */
class SystemAdvancementRoversSecondFactory extends Factory
{
    protected $model = SystemAdvancementRoversSecond::class;

    public function definition(): array
    {
        return [
            'advancmentID' => SystemAdvancementRoversLevel::factory(),
            'name' => fake()->unique()->words(3, true),
            'short' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
            'theme' => 0,
            'campingTask' => 0,
            'badgeTask' => 0,
            'active' => 1,
        ];
    }
}
