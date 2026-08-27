<?php

namespace Database\Factories;

use App\Models\SystemCity;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemCity> */
class SystemCityFactory extends Factory
{
    protected $model = SystemCity::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'name' => fake()->unique()->city(),
            'active' => 1,
        ];
    }
}
