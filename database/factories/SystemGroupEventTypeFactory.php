<?php

namespace Database\Factories;

use App\Models\SystemGroupEventType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemGroupEventType> */
class SystemGroupEventTypeFactory extends Factory
{
    protected $model = SystemGroupEventType::class;

    public function definition(): array
    {
        return [
            'position' => fake()->numberBetween(1, 100),
            'name' => fake()->unique()->words(2, true),
            'active' => 1,
        ];
    }
}
