<?php

namespace Database\Factories;

use App\Models\AmsChargeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsChargeType> */
class AmsChargeTypeFactory extends Factory
{
    protected $model = AmsChargeType::class;

    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 100),
            'name' => fake()->unique()->words(2, true),
            'shortName' => fake()->lexify('???'),
            'description' => fake()->sentence(),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
