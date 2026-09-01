<?php

namespace Database\Factories;

use App\Models\SystemBadgeScoutsFirst;
use App\Models\SystemBadgeScoutsSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeScoutsSecond> */
class SystemBadgeScoutsSecondFactory extends Factory
{
    protected $model = SystemBadgeScoutsSecond::class;

    public function definition(): array
    {
        return [
            'firstID' => SystemBadgeScoutsFirst::factory(),
            'heading' => fake()->words(2, true),
            'task' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
            'active' => 1,
        ];
    }
}
