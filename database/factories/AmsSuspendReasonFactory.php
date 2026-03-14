<?php

namespace Database\Factories;

use App\Models\AmsSuspendReason;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsSuspendReason> */
class AmsSuspendReasonFactory extends Factory
{
    protected $model = AmsSuspendReason::class;

    public function definition(): array
    {
        return [
            'reason' => fake()->unique()->sentence(4),
        ];
    }
}
