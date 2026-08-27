<?php

namespace Database\Factories;

use App\Models\SystemProgramTypesRover;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemProgramTypesRover> */
class SystemProgramTypesRoverFactory extends Factory
{
    protected $model = SystemProgramTypesRover::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'name' => fake()->unique()->words(2, true),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
