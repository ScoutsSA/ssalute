<?php

namespace Database\Factories;

use App\Models\MembershipCertificate;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MembershipCertificate>
 */
class MembershipCertificateFactory extends Factory
{
    protected $model = MembershipCertificate::class;

    public function definition(): array
    {
        return [
            'user_id' => SystemUser::factory(),
            'visible_fields' => ['name', 'ssa_id', 'roles'],
        ];
    }
}
