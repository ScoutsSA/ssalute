<?php

namespace Database\Factories;

use App\Models\ProjectsFor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ProjectsFor> */
class ProjectsForFactory extends Factory
{
    protected $model = ProjectsFor::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'name' => fake()->unique()->words(2, true),
            'active' => 1,
        ];
    }
}
