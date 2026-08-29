<?php

namespace Database\Factories;

use App\Models\SystemFaq;
use App\Models\SystemFaqCat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemFaq> */
class SystemFaqFactory extends Factory
{
    protected $model = SystemFaq::class;

    public function definition(): array
    {
        return [
            'catID' => SystemFaqCat::factory(),
            'targetID' => 0,
            'q' => fake()->unique()->sentence(),
            'a' => '<p>' . fake()->paragraph() . '</p>',
            'active' => 1,
            'position' => 0,
        ];
    }
}
