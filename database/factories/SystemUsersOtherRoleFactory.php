<?php

namespace Database\Factories;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SystemUsersOtherRole>
 */
class SystemUsersOtherRoleFactory extends Factory
{
    protected $model = SystemUsersOtherRole::class;

    public function definition(): array
    {
        return [
            'userID' => SystemUser::factory(),
            'roleID' => SystemUserType::factory(),
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }

    public function forUser(SystemUser $user): static
    {
        return $this->state(['userID' => $user->id]);
    }

    public function ofType(SystemUserType $type): static
    {
        return $this->state(['roleID' => $type->id]);
    }
}
