<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legacyPermissions = [
            Permission::LEGACY_CAN_ADMIN_ALUMNI => 'Can Administer Alumni',
            Permission::LEGACY_CAN_SEE_ALUMNI => 'Can View Alumni',
            Permission::LEGACY_CAN_ADMIN_NATIONAL => 'Can Administer National',
            Permission::LEGACY_CAN_SEE_NATIONAL => 'Can View National',
            Permission::LEGACY_CAN_ADMIN_REGION => 'Can Administer Region',
            Permission::LEGACY_CAN_SEE_REGION => 'Can View Region',
            Permission::LEGACY_CAN_ADMIN_REGION_KIDS => 'Can Administer Region Kids',
            Permission::LEGACY_CAN_ADMIN_REGION_TRAINING => 'Can Administer Region Training',
            Permission::LEGACY_CAN_ADMIN_SUPER_DISTRICT => 'Can Administer Super District',
            Permission::LEGACY_CAN_SEE_SUPER_DISTRICT => 'Can View Super District',
            Permission::LEGACY_CAN_ADMIN_DISTRICT => 'Can Administer District',
            Permission::LEGACY_CAN_SEE_DISTRICT => 'Can View District',
            Permission::LEGACY_CAN_ADMIN_DISTRICT_KIDS => 'Can Administer District Kids',
            Permission::LEGACY_CAN_ADMIN_GROUP => 'Can Administer Group',
            Permission::LEGACY_CAN_SEE_GROUP => 'Can View Group',
            Permission::LEGACY_CAN_ADMIN_GROUP_ADULTS => 'Can Administer Group Adults',
            Permission::LEGACY_CAN_AWARD_GROUP_MEERKATS => 'Can Award Group Meerkats',
            Permission::LEGACY_CAN_AWARD_GROUP_CUBS => 'Can Award Group Cubs',
            Permission::LEGACY_CAN_AWARD_GROUP_SCOUTS => 'Can Award Group Scouts',
            Permission::LEGACY_CAN_AWARD_GROUP_ROVERS => 'Can Award Group Rovers',
            Permission::LEGACY_CAN_SEE_SUPPORT => 'Can View Support',
            Permission::LEGACY_CAN_ADMIN_SUPPORT => 'Can Administer Support',
            Permission::LEGACY_CAN_ADD_WARRANTS => 'Can Add Warrants',
            Permission::LEGACY_CAN_ADMIN_PROPERTY => 'Can Administer Property',
            Permission::LEGACY_CAN_SIGN_WARRANTS => 'Can Sign Warrants',
            Permission::LEGACY_CAN_ADMIN_FORM29 => 'Can Administer Form29',
            Permission::LEGACY_CAN_ADMIN_POLICE_CLEARANCE => 'Can Administer Police Clearance',
        ];

        foreach ($legacyPermissions as $systemName => $displayName) {
            Permission::firstOrCreate(['system_name' => $systemName], ['display_name' => $displayName]);
        }
    }
}
