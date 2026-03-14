<?php

namespace Database\Factories;

use App\Models\SystemAccountType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAccountType> */
class SystemAccountTypeFactory extends Factory
{
    protected $model = SystemAccountType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
        ];
    }
}
