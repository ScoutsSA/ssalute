<?php

namespace Database\Factories;

use App\Models\SystemFinancialFeeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemFinancialFeeType> */
class SystemFinancialFeeTypeFactory extends Factory
{
    protected $model = SystemFinancialFeeType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'canBeProrated' => 0,
            'active' => 1,
        ];
    }
}
