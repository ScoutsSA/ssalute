<?php

namespace Database\Factories;

use App\Models\AdminGoodLogon;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AdminGoodLogon> */
class AdminGoodLogonFactory extends Factory
{
    protected $model = AdminGoodLogon::class;

    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'password' => '',
            'date' => fake()->dateTimeBetween('-30 days'),
            'ip' => fake()->ipv4(),
            'fromSD' => 2,
            'roleID' => 0,
            'groupID' => 0,
            'districtID' => 0,
            'regionID' => 0,
            'countryID' => 196,
            'userAgent' => fake()->userAgent(),
            'usingMobile' => 0,
        ];
    }
}
