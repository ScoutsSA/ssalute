<?php

namespace Database\Factories;

use App\Models\SystemUser;
use App\Models\SystemUserLogging;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SystemUserLogging> */
class SystemUserLoggingFactory extends Factory
{
    protected $model = SystemUserLogging::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'regionID' => 0,
            'districtID' => 0,
            'groupID' => 0,
            'userID' => SystemUser::factory(),
            'page' => '/' . fake()->slug(2),
            'IP' => fake()->ipv4(),
            'userAgent' => fake()->userAgent(),
            'created' => fake()->dateTimeBetween('-7 days'),
        ];
    }
}
