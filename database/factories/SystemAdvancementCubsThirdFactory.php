<?php

namespace Database\Factories;

use App\Models\SystemAdvancementCubsLevel;
use App\Models\SystemAdvancementCubsSecond;
use App\Models\SystemAdvancementCubsThird;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementCubsThird> */
class SystemAdvancementCubsThirdFactory extends Factory
{
    protected $model = SystemAdvancementCubsThird::class;

    public function definition(): array
    {
        return [
            'advancmentID' => SystemAdvancementCubsLevel::factory(),
            'secondID' => SystemAdvancementCubsSecond::factory(),
            'name' => fake()->unique()->words(3, true),
            'short' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'challenge' => 'Outdoor Challenge',
            'theme' => 0,
            'note' => '',
            'position' => fake()->numberBetween(1, 100),
            'campingTask' => 0,
            'badgeTask' => 0,
            'active' => 1,
        ];
    }
}
