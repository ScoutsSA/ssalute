<?php

namespace Database\Factories;

use App\Models\SystemBadgeCubsFirst;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeCubsFirst> */
class SystemBadgeCubsFirstFactory extends Factory
{
    protected $model = SystemBadgeCubsFirst::class;

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
