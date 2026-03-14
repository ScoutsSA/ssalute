<?php

namespace Database\Factories;

use App\Models\SystemRoverMeetingType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemRoverMeetingType> */
class SystemRoverMeetingTypeFactory extends Factory
{
    protected $model = SystemRoverMeetingType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
        ];
    }
}
