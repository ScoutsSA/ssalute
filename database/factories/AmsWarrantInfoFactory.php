<?php

namespace Database\Factories;

use App\Models\AmsWarrantInfo;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AmsWarrantInfo>
 */
class AmsWarrantInfoFactory extends Factory
{
    protected $model = AmsWarrantInfo::class;

    public function definition(): array
    {
        return [
            'userID' => SystemUser::factory(),
            'roleID' => SystemUserType::factory(),
            'countryID' => 196,
            'assocToRegion' => 0,
            'assocToDistrict' => 0,
            'assocToGroup' => 0,
            'warrantTypeID' => 1,
            'warrantNr' => 'SSA' . $this->faker->unique()->numerify('###'),
            'warrantName' => $this->faker->jobTitle(),
            'issueDate' => now()->subYear(),
            'expireDate' => now()->addYears(2),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function forRoleAttachment(SystemUsersOtherRole $roleAttachment): static
    {
        return $this->state([
            'userID' => $roleAttachment->userID,
            'roleID' => $roleAttachment->roleID,
            'countryID' => $roleAttachment->actionCountryID ?? 0,
            'assocToRegion' => $roleAttachment->actionRegionID ?? 0,
            'assocToDistrict' => $roleAttachment->actionDistrictID ?? 0,
            'assocToGroup' => $roleAttachment->actionGroupID ?? 0,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }

    public function expired(): static
    {
        return $this->state([
            'issueDate' => now()->subYears(3),
            'expireDate' => now()->subYear(),
        ]);
    }
}
