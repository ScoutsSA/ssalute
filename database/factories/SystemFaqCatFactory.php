<?php

namespace Database\Factories;

use App\Models\SystemFaqCat;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemFaqCat> */
class SystemFaqCatFactory extends Factory
{
    protected $model = SystemFaqCat::class;

    public function definition(): array
    {
        return [
            'faqGroup' => 0,
            'position' => 0,
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'forNational' => 0,
            'forRegion' => 0,
            'forDistrict' => 0,
            'forGroupAdults' => 0,
            'forGroupParents' => 0,
            'forGroupScouts' => 0,
            'forGroupRovers' => 0,
            'forAlumni' => 0,
            'active' => 1,
        ];
    }
}
