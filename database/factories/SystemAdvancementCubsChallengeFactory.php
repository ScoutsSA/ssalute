<?php

namespace Database\Factories;

use App\Models\SystemAdvancementCubsChallenge;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementCubsChallenge> */
class SystemAdvancementCubsChallengeFactory extends Factory
{
    protected $model = SystemAdvancementCubsChallenge::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true) . ' Challenge',
        ];
    }
}
