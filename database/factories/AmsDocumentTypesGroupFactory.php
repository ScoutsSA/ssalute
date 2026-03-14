<?php

namespace Database\Factories;

use App\Models\AmsDocumentTypesGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsDocumentTypesGroup> */
class AmsDocumentTypesGroupFactory extends Factory
{
    protected $model = AmsDocumentTypesGroup::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
        ];
    }
}
