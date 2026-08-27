<?php

namespace Database\Factories;

use App\Models\InfoSharingType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<InfoSharingType> */
class InfoSharingTypeFactory extends Factory
{
    protected $model = InfoSharingType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'active' => 1,
        ];
    }
}
