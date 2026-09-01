<?php

namespace Database\Factories;

use App\Models\SystemAdvancementMeerkatsLevel;
use App\Models\SystemAdvancementMeerkatsSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementMeerkatsSecond> */
class SystemAdvancementMeerkatsSecondFactory extends Factory
{
    protected $model = SystemAdvancementMeerkatsSecond::class;

    public function definition(): array
    {
        return [
            'advancmentID' => SystemAdvancementMeerkatsLevel::factory(),
            'name' => fake()->unique()->words(3, true),
            'short' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
            'badgeTask' => 0,
            'theme' => 0,
            'active' => 1,
        ];
    }
}
