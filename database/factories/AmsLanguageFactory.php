<?php

namespace Database\Factories;

use App\Models\AmsLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsLanguage> */
class AmsLanguageFactory extends Factory
{
    protected $model = AmsLanguage::class;

    public function definition(): array
    {
        return [
            'language' => fake()->unique()->word(),
        ];
    }
}
