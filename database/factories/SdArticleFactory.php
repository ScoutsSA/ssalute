<?php

namespace Database\Factories;

use App\Models\SdArticle;
use App\Models\SdArticleCat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SdArticle> */
class SdArticleFactory extends Factory
{
    protected $model = SdArticle::class;

    public function definition(): array
    {
        return [
            'catID' => SdArticleCat::factory(),
            'groupID' => 0,
            'title' => fake()->unique()->sentence(4),
            'slug' => fake()->unique()->slug(3),
            'intro' => fake()->paragraph(),
            'article' => '<p>' . fake()->paragraph() . '</p>',
            'active' => 1,
            'created' => now(),
            'createdby' => '1',
            'views' => 0,
        ];
    }
}
