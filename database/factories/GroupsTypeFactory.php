<?php

namespace Database\Factories;

use App\Models\GroupsType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<GroupsType> */
class GroupsTypeFactory extends Factory
{
    protected $model = GroupsType::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
        ];
    }
}
