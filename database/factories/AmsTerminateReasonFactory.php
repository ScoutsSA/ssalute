<?php

namespace Database\Factories;

use App\Models\AmsTerminateReason;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsTerminateReason> */
class AmsTerminateReasonFactory extends Factory
{
    protected $model = AmsTerminateReason::class;

    public function definition(): array
    {
        return [
            'reason' => fake()->unique()->sentence(4),
        ];
    }
}
