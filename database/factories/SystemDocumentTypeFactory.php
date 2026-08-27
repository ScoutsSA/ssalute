<?php

namespace Database\Factories;

use App\Models\SystemDocumentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemDocumentType> */
class SystemDocumentTypeFactory extends Factory
{
    protected $model = SystemDocumentType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(),
            'youth' => 1,
        ];
    }
}
