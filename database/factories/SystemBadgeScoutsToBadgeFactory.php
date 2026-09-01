<?php

namespace Database\Factories;

use App\Models\SystemBadgeScoutsFirst;
use App\Models\SystemBadgeScoutsSecond;
use App\Models\SystemBadgeScoutsToBadge;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemBadgeScoutsToBadge> */
class SystemBadgeScoutsToBadgeFactory extends Factory
{
    protected $model = SystemBadgeScoutsToBadge::class;

    public function definition(): array
    {
        return [
            'badgeID' => SystemBadgeScoutsFirst::factory(),
            'toBadgeTaskID' => SystemBadgeScoutsSecond::factory(),
            'active' => 1,
        ];
    }
}
