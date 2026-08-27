<?php

namespace Database\Factories;

use App\Models\SdArticleCat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SdArticleCat> */
class SdArticleCatFactory extends Factory
{
    protected $model = SdArticleCat::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'slug' => fake()->unique()->slug(2),
        ];
    }
}
