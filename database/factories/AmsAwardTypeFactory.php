<?php

namespace Database\Factories;

use App\Models\AmsAwardHeading;
use App\Models\AmsAwardType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsAwardType> */
class AmsAwardTypeFactory extends Factory
{
    protected $model = AmsAwardType::class;

    public function definition(): array
    {
        return [
            'headingID' => AmsAwardHeading::factory(),
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
