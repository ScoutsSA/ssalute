<?php

namespace Database\Factories;

use App\Models\SystemRoadmapLittle;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemRoadmapLittle> */
class SystemRoadmapLittleFactory extends Factory
{
    protected $model = SystemRoadmapLittle::class;

    public function definition(): array
    {
        return [
            'area' => fake()->words(2, true),
            'text' => fake()->paragraph(),
            'releaseDate' => now()->toDateString(),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
