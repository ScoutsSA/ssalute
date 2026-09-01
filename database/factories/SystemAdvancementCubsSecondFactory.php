<?php

namespace Database\Factories;

use App\Models\SystemAdvancementCubsLevel;
use App\Models\SystemAdvancementCubsSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementCubsSecond> */
class SystemAdvancementCubsSecondFactory extends Factory
{
    protected $model = SystemAdvancementCubsSecond::class;

    public function definition(): array
    {
        return [
            'advancmentID' => SystemAdvancementCubsLevel::factory(),
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
        ];
    }
}
