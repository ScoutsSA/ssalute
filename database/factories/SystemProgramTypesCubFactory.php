<?php

namespace Database\Factories;

use App\Models\SystemProgramTypesCub;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemProgramTypesCub> */
class SystemProgramTypesCubFactory extends Factory
{
    protected $model = SystemProgramTypesCub::class;

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
