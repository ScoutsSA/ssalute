<?php

namespace Database\Factories;

use App\Models\SystemProgramTypesMeerkat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemProgramTypesMeerkat> */
class SystemProgramTypesMeerkatFactory extends Factory
{
    protected $model = SystemProgramTypesMeerkat::class;

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
