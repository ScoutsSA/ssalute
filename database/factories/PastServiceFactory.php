<?php

namespace Database\Factories;

use App\Models\AmsPastServiceType;
use App\Models\PastService;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PastService> */
class PastServiceFactory extends Factory
{
    protected $model = PastService::class;

    public function definition(): array
    {
        return [
            'userID' => SystemUser::factory(),
            'countryID' => 196,
            'assocToRegion' => 0,
            'assocToDistrict' => 0,
            'assocToGroup' => 0,
            'pastServiceType' => AmsPastServiceType::factory(),
            'startDate' => now()->subYears(3),
            'endDate' => now()->subYear(),
            'active' => 1,
            'toBeFixed' => 0,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
