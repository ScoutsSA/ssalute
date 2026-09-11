<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<District> */
class DistrictFactory extends Factory
{
    protected $model = District::class;

    public function definition(): array
    {
        return [
            'regionID' => Region::factory(),
            'superDistrictID' => 0,
            'name' => fake()->unique()->city() . ' District',
            'description' => '',
            'phys_address' => '',
            'countryID' => 196,
            'active' => 1,
            'accountID' => 0,
            'censusDone' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function forRegion(Region $region): static
    {
        return $this->state(['regionID' => $region->id]);
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
