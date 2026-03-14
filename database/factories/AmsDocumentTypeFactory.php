<?php

namespace Database\Factories;

use App\Models\AmsDocumentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsDocumentType> */
class AmsDocumentTypeFactory extends Factory
{
    protected $model = AmsDocumentType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'aamForm' => 0,
            'active' => 1,
        ];
    }
}
