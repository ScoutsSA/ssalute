<?php

namespace Database\Factories;

use App\Models\AmsLicenceInfo;
use App\Models\AmsLicenceType;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AmsLicenceInfo> */
class AmsLicenceInfoFactory extends Factory
{
    protected $model = AmsLicenceInfo::class;

    public function definition(): array
    {
        return [
            'userID' => SystemUser::factory(),
            'countryID' => 196,
            'assocToRegion' => 0,
            'assocToDistrict' => 0,
            'assocToGroup' => 0,
            'chargeTypeID' => AmsLicenceType::factory(),
            'chargeNr' => fake()->unique()->numerify('LIC-#####'),
            'issueDate' => now()->subYear(),
            'expireDate' => now()->addYears(4),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function expired(): static
    {
        return $this->state([
            'issueDate' => now()->subYears(6),
            'expireDate' => now()->subYear(),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
