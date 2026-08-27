<?php

namespace Database\Factories;

use App\Models\SupportChatsStandardAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SupportChatsStandardAnswer> */
class SupportChatsStandardAnswerFactory extends Factory
{
    protected $model = SupportChatsStandardAnswer::class;

    public function definition(): array
    {
        return [
            'answer' => fake()->paragraph(),
            'autoClose' => 0,
            'active' => 1,
        ];
    }
}
