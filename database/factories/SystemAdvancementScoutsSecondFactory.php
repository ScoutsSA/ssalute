<?php

namespace Database\Factories;

use App\Models\SystemAdvancementScoutsLevel;
use App\Models\SystemAdvancementScoutsSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementScoutsSecond> */
class SystemAdvancementScoutsSecondFactory extends Factory
{
    protected $model = SystemAdvancementScoutsSecond::class;

    public function definition(): array
    {
        return [
            'advancmentID' => SystemAdvancementScoutsLevel::factory(),
            'name' => fake()->unique()->words(3, true),
            'short' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
            'campingTask' => 0,
            'badgeTask' => 0,
            'PGATask' => 0,
            'active' => 1,
        ];
    }
}
