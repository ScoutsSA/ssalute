<?php

namespace Database\Factories;

use App\Models\AmsDisciplinaryHeading;
use App\Models\AmsDisciplinaryOffence;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsDisciplinaryOffence> */
class AmsDisciplinaryOffenceFactory extends Factory
{
    protected $model = AmsDisciplinaryOffence::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'headingID' => AmsDisciplinaryHeading::factory(),
            'offense' => fake()->sentence(),
            'active' => 1,
        ];
    }
}
