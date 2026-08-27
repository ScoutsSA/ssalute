<?php

namespace Database\Factories;

use App\Models\EventCompetitionsJudgesType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<EventCompetitionsJudgesType> */
class EventCompetitionsJudgesTypeFactory extends Factory
{
    protected $model = EventCompetitionsJudgesType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'canAdmin' => 0,
            'canCaptureScores' => 0,
            'canAdminJudges' => 0,
            'canAdminFinances' => 0,
            'canAdminTeams' => 0,
            'medical' => 0,
            'seaWorthiness' => 0,
            'active' => 1,
        ];
    }
}
