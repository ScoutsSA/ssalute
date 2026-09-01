<?php

namespace Database\Factories;

use App\Models\SystemBadgeMeerkatsFirst;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeMeerkatsFirst> */
class SystemBadgeMeerkatsFirstFactory extends Factory
{
    protected $model = SystemBadgeMeerkatsFirst::class;

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
