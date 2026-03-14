<?php

namespace Database\Factories;

use App\Models\AmsRetireReason;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsRetireReason> */
class AmsRetireReasonFactory extends Factory
{
    protected $model = AmsRetireReason::class;

    public function definition(): array
    {
        return [
            'reason' => fake()->unique()->sentence(4),
        ];
    }
}
