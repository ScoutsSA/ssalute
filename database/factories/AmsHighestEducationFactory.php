<?php

namespace Database\Factories;

use App\Models\AmsHighestEducation;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsHighestEducation> */
class AmsHighestEducationFactory extends Factory
{
    protected $model = AmsHighestEducation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
        ];
    }
}
