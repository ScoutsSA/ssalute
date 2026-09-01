<?php

namespace Database\Factories;

use App\Models\SystemBadgeMeerkatsFirst;
use App\Models\SystemBadgeMeerkatsSecond;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeMeerkatsSecond> */
class SystemBadgeMeerkatsSecondFactory extends Factory
{
    protected $model = SystemBadgeMeerkatsSecond::class;

    public function definition(): array
    {
        return [
            'firstID' => SystemBadgeMeerkatsFirst::factory(),
            'heading' => fake()->words(2, true),
            'task' => fake()->sentence(),
            'position' => fake()->numberBetween(1, 100),
            'active' => 1,
        ];
    }
}
