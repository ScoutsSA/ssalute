<?php

namespace Database\Factories;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SystemUser>
 */
class SystemUserFactory extends Factory
{
    protected $model = SystemUser::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'active' => 1,
            'canLogon' => 1,
            'assoc_to_account' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }

    /**
     * Attach an active role of the given type to the user after creation.
     */
    public function withRole(?SystemUserType $roleType = null): static
    {
        return $this->afterCreating(function (SystemUser $user) use ($roleType) {
            $roleType ??= SystemUserType::factory()->create();

            SystemUsersOtherRole::create([
                'userID' => $user->id,
                'roleID' => $roleType->id,
                'active' => 1,
                'created' => now(),
                'createdby' => 1,
            ]);
        });
    }
}
