<?php

namespace Database\Factories;

use App\Models\SystemStarAwardType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemStarAwardType> */
class SystemStarAwardTypeFactory extends Factory
{
    protected $model = SystemStarAwardType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'area' => fake()->numberBetween(1, 10),
            'position' => fake()->numberBetween(1, 100),
            'active' => 1,
        ];
    }
}
