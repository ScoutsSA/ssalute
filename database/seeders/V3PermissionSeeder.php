<?php

namespace Database\Seeders;

use App\Models\V3\V3Permission;
use Illuminate\Database\Seeder;

class V3PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legacyPermissions = [
            V3Permission::LEGACY_CAN_ADMIN_ALUMNI => 'Can Administer Alumni',
            V3Permission::LEGACY_CAN_SEE_ALUMNI => 'Can View Alumni',
            V3Permission::LEGACY_CAN_ADMIN_NATIONAL => 'Can Administer National',
            V3Permission::LEGACY_CAN_SEE_NATIONAL => 'Can View National',
            V3Permission::LEGACY_CAN_ADMIN_REGION => 'Can Administer V3Region',
            V3Permission::LEGACY_CAN_SEE_REGION => 'Can View V3Region',
            V3Permission::LEGACY_CAN_ADMIN_REGION_KIDS => 'Can Administer V3Region Kids',
            V3Permission::LEGACY_CAN_ADMIN_REGION_TRAINING => 'Can Administer V3Region Training',
            V3Permission::LEGACY_CAN_ADMIN_SUPER_DISTRICT => 'Can Administer Super V3District',
            V3Permission::LEGACY_CAN_SEE_SUPER_DISTRICT => 'Can View Super V3District',
            V3Permission::LEGACY_CAN_ADMIN_DISTRICT => 'Can Administer V3District',
            V3Permission::LEGACY_CAN_SEE_DISTRICT => 'Can View V3District',
            V3Permission::LEGACY_CAN_ADMIN_DISTRICT_KIDS => 'Can Administer V3District Kids',
            V3Permission::LEGACY_CAN_ADMIN_GROUP => 'Can Administer V3Group',
            V3Permission::LEGACY_CAN_SEE_GROUP => 'Can View V3Group',
            V3Permission::LEGACY_CAN_ADMIN_GROUP_ADULTS => 'Can Administer V3Group Adults',
            V3Permission::LEGACY_CAN_AWARD_GROUP_MEERKATS => 'Can Award V3Group Meerkats',
            V3Permission::LEGACY_CAN_AWARD_GROUP_CUBS => 'Can Award V3Group Cubs',
            V3Permission::LEGACY_CAN_AWARD_GROUP_SCOUTS => 'Can Award V3Group Scouts',
            V3Permission::LEGACY_CAN_AWARD_GROUP_ROVERS => 'Can Award V3Group Rovers',
            V3Permission::LEGACY_CAN_SEE_SUPPORT => 'Can View Support',
            V3Permission::LEGACY_CAN_ADMIN_SUPPORT => 'Can Administer Support',
            V3Permission::LEGACY_CAN_ADD_WARRANTS => 'Can Add Warrants',
            V3Permission::LEGACY_CAN_ADMIN_PROPERTY => 'Can Administer Property',
            V3Permission::LEGACY_CAN_SIGN_WARRANTS => 'Can Sign Warrants',
            V3Permission::LEGACY_CAN_ADMIN_FORM29 => 'Can Administer Form29',
            V3Permission::LEGACY_CAN_ADMIN_POLICE_CLEARANCE => 'Can Administer Police Clearance',
        ];

        foreach ($legacyPermissions as $systemName => $displayName) {
            V3Permission::firstOrCreate(['system_name' => $systemName], ['display_name' => $displayName]);
        }
    }
}
