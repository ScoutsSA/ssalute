<?php

namespace Database\Factories;

use App\Models\SystemBadgeRoversFirst;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeRoversFirst> */
class SystemBadgeRoversFirstFactory extends Factory
{
    protected $model = SystemBadgeRoversFirst::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'type' => fake()->randomElement(['Interest', 'Challenge', 'SDG', 'Special']),
            'note' => fake()->sentence(),
            'active' => 1,
        ];
    }
}
