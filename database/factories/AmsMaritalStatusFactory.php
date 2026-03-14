<?php

namespace Database\Factories;

use App\Models\AmsMaritalStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsMaritalStatus> */
class AmsMaritalStatusFactory extends Factory
{
    protected $model = AmsMaritalStatus::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
        ];
    }
}
