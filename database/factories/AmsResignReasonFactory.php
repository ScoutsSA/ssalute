<?php

namespace Database\Factories;

use App\Models\AmsResignReason;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsResignReason> */
class AmsResignReasonFactory extends Factory
{
    protected $model = AmsResignReason::class;

    public function definition(): array
    {
        return [
            'reason' => fake()->unique()->sentence(4),
        ];
    }
}
