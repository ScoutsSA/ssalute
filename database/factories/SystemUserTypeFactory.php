<?php

namespace Database\Factories;

use App\Models\SystemUserType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SystemUserType>
 */
class SystemUserTypeFactory extends Factory
{
    protected $model = SystemUserType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence(),
            'groupRole' => 1,
            'active' => 1,
            'createdby' => 1,
        ];
    }

    public function national(): static
    {
        return $this->state(['nationalRole' => 1, 'groupRole' => 0]);
    }

    public function regional(): static
    {
        return $this->state(['regionalRole' => 1, 'groupRole' => 0]);
    }

    public function district(): static
    {
        return $this->state(['districtRole' => 1, 'groupRole' => 0]);
    }

    public function group(): static
    {
        return $this->state(['groupRole' => 1]);
    }

    public function warranted(): static
    {
        return $this->state(['warrantedRole' => 1, 'adultLeaderRole' => 1]);
    }

    public function appointment(): static
    {
        return $this->state(['appointmentRole' => 1, 'adultLeaderRole' => 1]);
    }
}
