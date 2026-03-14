<?php

namespace Database\Factories;

use App\Models\AmsPastServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsPastServiceType> */
class AmsPastServiceTypeFactory extends Factory
{
    protected $model = AmsPastServiceType::class;

    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 100),
            'name' => fake()->unique()->words(2, true),
        ];
    }
}
