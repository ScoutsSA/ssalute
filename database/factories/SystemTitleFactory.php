<?php

namespace Database\Factories;

use App\Models\SystemTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemTitle> */
class SystemTitleFactory extends Factory
{
    protected $model = SystemTitle::class;

    public function definition(): array
    {
        return [
            'title' => fake()->unique()->title(),
        ];
    }
}
