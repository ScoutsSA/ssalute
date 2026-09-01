<?php

namespace Database\Factories;

use App\Models\SystemAdvancementScoutsSecondEntshaTheme;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemAdvancementScoutsSecondEntshaTheme> */
class SystemAdvancementScoutsSecondEntshaThemeFactory extends Factory
{
    protected $model = SystemAdvancementScoutsSecondEntshaTheme::class;

    public function definition(): array
    {
        return [
            'themeName' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
        ];
    }
}
