<?php

namespace Database\Factories;

use App\Models\SystemCommitteeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemCommitteeType> */
class SystemCommitteeTypeFactory extends Factory
{
    protected $model = SystemCommitteeType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
