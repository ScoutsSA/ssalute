<?php

namespace Database\Factories;

use App\Models\AmsTrainingPastType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsTrainingPastType> */
class AmsTrainingPastTypeFactory extends Factory
{
    protected $model = AmsTrainingPastType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'shortName' => fake()->lexify('???'),
            'description' => fake()->sentence(),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
