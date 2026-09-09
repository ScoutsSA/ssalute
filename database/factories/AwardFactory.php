<?php

namespace Database\Factories;

use App\Models\AmsAwardHeading;
use App\Models\AmsAwardType;
use App\Models\Award;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Award> */
class AwardFactory extends Factory
{
    protected $model = Award::class;

    public function definition(): array
    {
        return [
            'userID' => SystemUser::factory(),
            'countryID' => 196,
            'assocToRegion' => 0,
            'assocToDistrict' => 0,
            'assocToGroup' => 0,
            'awardHeadingID' => AmsAwardHeading::factory(),
            'awardTypeID' => AmsAwardType::factory(),
            'awardDate' => now()->subMonth(),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
