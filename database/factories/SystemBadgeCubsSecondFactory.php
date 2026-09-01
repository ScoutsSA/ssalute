<?php

namespace Database\Factories;

use App\Models\SystemBadgeCubsFirst;
use App\Models\SystemBadgeCubsSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeCubsSecond> */
class SystemBadgeCubsSecondFactory extends Factory
{
    protected $model = SystemBadgeCubsSecond::class;

    public function definition(): array
    {
        return [
            'firstID' => SystemBadgeCubsFirst::factory(),
            'heading' => fake()->words(2, true),
            'task' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
            'active' => 1,
        ];
    }
}
