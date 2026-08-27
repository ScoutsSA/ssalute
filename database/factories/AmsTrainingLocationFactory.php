<?php

namespace Database\Factories;

use App\Models\AmsTrainingLocation;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsTrainingLocation> */
class AmsTrainingLocationFactory extends Factory
{
    protected $model = AmsTrainingLocation::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'assocToRegion' => fn (): int => Region::query()->create(['name' => fake()->city(), 'description' => '', 'phys_address' => '', 'countryID' => 196])->id,
            'name' => fake()->unique()->words(3, true),
            'address' => fake()->address(),
            'gpsLat' => '',
            'gpsLon' => '',
            'trainingSeats' => 20,
            'contact' => fake()->name(),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
