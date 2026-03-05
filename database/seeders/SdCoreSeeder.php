<?php

namespace Database\Seeders;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Illuminate\Database\Seeder;

class SdCoreSeeder extends Seeder
{
    public function run(): void
    {
        $groupRole = SystemUserType::factory()->group()->create(['name' => 'Group Leader']);
        $districtRole = SystemUserType::factory()->district()->create(['name' => 'District Commissioner']);
        $regionalRole = SystemUserType::factory()->regional()->create(['name' => 'Regional Commissioner']);
        $nationalRole = SystemUserType::factory()->national()->create(['name' => 'National Commissioner']);

        // A regular member with a single group role
        SystemUser::factory()->withRole($groupRole)->create([
            'username' => 'group.leader@example.com',
            'first_name' => 'Group',
            'surname' => 'Leader',
        ]);

        // A district-level manager with multiple roles
        $districtManager = SystemUser::factory()->create([
            'username' => 'district.commissioner@example.com',
            'first_name' => 'District',
            'surname' => 'Commissioner',
        ]);
        SystemUsersOtherRole::factory()->forUser($districtManager)->ofType($districtRole)->create();
        SystemUsersOtherRole::factory()->forUser($districtManager)->ofType($groupRole)->create();

        // A national-level manager
        SystemUser::factory()->withRole($nationalRole)->create([
            'username' => 'national@example.com',
            'first_name' => 'National',
            'surname' => 'Commissioner',
        ]);

        // A user with no roles
        SystemUser::factory()->create([
            'username' => 'noroles@example.com',
            'first_name' => 'No',
            'surname' => 'Roles',
        ]);
    }
}
