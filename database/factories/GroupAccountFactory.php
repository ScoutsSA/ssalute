<?php

namespace Database\Factories;

use App\Models\GroupAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<GroupAccount> */
class GroupAccountFactory extends Factory
{
    protected $model = GroupAccount::class;

    public function definition(): array
    {
        return [
            'countryID' => 196,
            'accountName' => fake()->unique()->company() . ' Account',
            'accountType' => 1,
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }
}
