<?php

namespace Database\Factories;

use App\Models\SystemCountryName;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemCountryName> */
class SystemCountryNameFactory extends Factory
{
    protected $model = SystemCountryName::class;

    public function definition(): array
    {
        return [
            'country_code' => strtoupper(fake()->unique()->lexify('???')),
            'country_name' => fake()->unique()->words(2, true),
            'usingSD' => 0,
            'branch1StartingAge' => 5.0,
            'branch1EndingAge' => 7.0,
            'branch2StartingAge' => 7.0,
            'branch2EndingAge' => 11.0,
            'branch3StartingAge' => 11.0,
            'branch3EndingAge' => 18.0,
            'branch4StartingAge' => 18.0,
            'branch4EndingAge' => 25.0,
            'branch5StartingAge' => 25.0,
            'branch5EndingAge' => 35.0,
        ];
    }
}
