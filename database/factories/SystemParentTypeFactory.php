<?php

namespace Database\Factories;

use App\Models\SystemParentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemParentType> */
class SystemParentTypeFactory extends Factory
{
    protected $model = SystemParentType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
        ];
    }
}
