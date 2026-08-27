<?php

namespace Database\Factories;

use App\Models\SupportChatsType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SupportChatsType> */
class SupportChatsTypeFactory extends Factory
{
    protected $model = SupportChatsType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'active' => 1,
        ];
    }
}
