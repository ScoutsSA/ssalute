<?php

namespace Database\Factories;

use App\Models\AmsTrainingCourse;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsTrainingCourse> */
class AmsTrainingCourseFactory extends Factory
{
    protected $model = AmsTrainingCourse::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'courseType' => null,
            'assocToRegion' => fn (): int => Region::query()->create(['name' => fake()->city(), 'description' => '', 'phys_address' => '', 'countryID' => 196])->id,
            'name' => fake()->unique()->words(3, true),
            'nrOfDays' => 1,
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
