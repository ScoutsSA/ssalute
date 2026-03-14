<?php

namespace Database\Factories;

use App\Models\AmsDisciplinaryHeading;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsDisciplinaryHeading> */
class AmsDisciplinaryHeadingFactory extends Factory
{
    protected $model = AmsDisciplinaryHeading::class;

    public function definition(): array
    {
        return [
            'reason' => fake()->unique()->sentence(4),
        ];
    }
}
