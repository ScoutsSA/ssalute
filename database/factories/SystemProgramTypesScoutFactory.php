<?php

namespace Database\Factories;

use App\Models\SystemProgramTypesScout;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemProgramTypesScout> */
class SystemProgramTypesScoutFactory extends Factory
{
    protected $model = SystemProgramTypesScout::class;

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
