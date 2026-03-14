<?php

namespace Database\Factories;

use App\Models\AmsTrainingCoursesType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsTrainingCoursesType> */
class AmsTrainingCoursesTypeFactory extends Factory
{
    protected $model = AmsTrainingCoursesType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'colour' => fake()->safeHexColor(),
            'active' => 1,
        ];
    }
}
