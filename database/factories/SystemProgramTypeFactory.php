<?php

namespace Database\Factories;

use App\Models\SystemProgramType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemProgramType> */
class SystemProgramTypeFactory extends Factory
{
    protected $model = SystemProgramType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'active' => 1,
        ];
    }
}
