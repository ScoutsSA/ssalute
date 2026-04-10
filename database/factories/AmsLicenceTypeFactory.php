<?php

namespace Database\Factories;

use App\Models\AmsLicenceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsLicenceType> */
class AmsLicenceTypeFactory extends Factory
{
    protected $model = AmsLicenceType::class;

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
