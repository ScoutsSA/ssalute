<?php

namespace Database\Factories;

use App\Models\GroupsPropertyOwnershipType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<GroupsPropertyOwnershipType> */
class GroupsPropertyOwnershipTypeFactory extends Factory
{
    protected $model = GroupsPropertyOwnershipType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'owned' => 0,
            'rented' => 0,
            'active' => 1,
        ];
    }
}
