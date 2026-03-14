<?php

namespace Database\Factories;

use App\Models\SystemAssetCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAssetCondition> */
class SystemAssetConditionFactory extends Factory
{
    protected $model = SystemAssetCondition::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'active' => 1,
        ];
    }
}
