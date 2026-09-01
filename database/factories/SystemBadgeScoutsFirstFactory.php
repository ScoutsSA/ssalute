<?php

namespace Database\Factories;

use App\Models\SystemBadgeScoutsFirst;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeScoutsFirst> */
class SystemBadgeScoutsFirstFactory extends Factory
{
    protected $model = SystemBadgeScoutsFirst::class;

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
