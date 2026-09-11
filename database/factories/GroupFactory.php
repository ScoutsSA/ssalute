<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Group;
use App\Models\GroupsType;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Group> */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'assoc_to_region' => Region::factory(),
            'assoc_to_district' => fn (array $attributes): int => District::factory()
                ->create(['regionID' => $attributes['assoc_to_region']])
                ->id,
            'groupTypeID' => GroupsType::factory(),
            'name' => fake()->unique()->numerify('##th') . ' ' . fake()->city(),
            'description' => '',
            'scarf' => '',
            'groupRegNr' => null,
            'active' => 1,
            'meerkatProgramType' => 1,
            'cubProgramType' => 1,
            'scoutProgramType' => 2,
            'roverProgramType' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function forRegion(Region $region): static
    {
        return $this->state(['assoc_to_region' => $region->id]);
    }

    public function forDistrict(District $district): static
    {
        return $this->state([
            'assoc_to_region' => $district->regionID,
            'assoc_to_district' => $district->id,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
