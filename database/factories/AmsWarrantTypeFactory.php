<?php

namespace Database\Factories;

use App\Models\AmsWarrantType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsWarrantType> */
class AmsWarrantTypeFactory extends Factory
{
    protected $model = AmsWarrantType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'shortName' => fake()->lexify('???'),
            'description' => fake()->sentence(),
            'national' => 0,
            'region' => 0,
            'district' => 0,
            'group' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
