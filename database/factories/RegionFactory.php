<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Region> */
class RegionFactory extends Factory
{
    protected $model = Region::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city() . ' Region',
            'short' => strtoupper(fake()->unique()->lexify('???')),
            'position' => 0,
            'usingAMS' => 1,
            'description' => '',
            'phys_address' => '',
            'countryID' => 196,
            'active' => 1,
            'accountID' => 0,
            'censusDone' => 1,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
