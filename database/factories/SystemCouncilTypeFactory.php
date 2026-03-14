<?php

namespace Database\Factories;

use App\Models\SystemCouncilType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemCouncilType> */
class SystemCouncilTypeFactory extends Factory
{
    protected $model = SystemCouncilType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
