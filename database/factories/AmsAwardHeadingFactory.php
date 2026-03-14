<?php

namespace Database\Factories;

use App\Models\AmsAwardHeading;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsAwardHeading> */
class AmsAwardHeadingFactory extends Factory
{
    protected $model = AmsAwardHeading::class;

    public function definition(): array
    {
        return [
            'reason' => fake()->unique()->sentence(4),
        ];
    }
}
