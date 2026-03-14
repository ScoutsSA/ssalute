<?php

namespace Database\Factories;

use App\Models\AmsWarrantCancellationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsWarrantCancellationType> */
class AmsWarrantCancellationTypeFactory extends Factory
{
    protected $model = AmsWarrantCancellationType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'active' => 1,
        ];
    }
}
