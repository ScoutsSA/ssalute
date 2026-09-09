<?php

namespace Database\Factories;

use App\Models\AmsTrainingPastType;
use App\Models\PastTraining;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PastTraining> */
class PastTrainingFactory extends Factory
{
    protected $model = PastTraining::class;

    public function definition(): array
    {
        return [
            'userID' => SystemUser::factory(),
            'countryID' => 196,
            'assocToRegion' => 0,
            'assocToDistrict' => 0,
            'assocToGroup' => 0,
            'trainingTypeID' => AmsTrainingPastType::factory(),
            'courseName' => fake()->words(3, true),
            'courseNumber' => fake()->numerify('TC-####'),
            'completionDate' => now()->subMonths(2),
            'active' => 1,
            'validated' => 0,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function validated(): static
    {
        return $this->state([
            'validated' => 1,
            'validatedDate' => now()->subMonth(),
            'validatedby' => 1,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
