<?php

namespace Database\Factories;

use App\Models\SystemBadgeRoversFirst;
use App\Models\SystemBadgeRoversSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeRoversSecond> */
class SystemBadgeRoversSecondFactory extends Factory
{
    protected $model = SystemBadgeRoversSecond::class;

    public function definition(): array
    {
        return [
            'firstID' => SystemBadgeRoversFirst::factory(),
            'heading' => fake()->words(2, true),
            'task' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
            'active' => 1,
        ];
    }
}
