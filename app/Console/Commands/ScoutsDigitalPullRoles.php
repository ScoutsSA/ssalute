<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\SsaRole;
use App\Models\V2\V2SystemUserType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalPullRoles extends Command
{
    protected $signature = 'sd:pull-roles';
    protected $description = 'Pulls rolls from Scouts Digital and ensures we have all the roles on our system';

    public function handle()
    {
        Log::info('ScoutsDigitalPullRoles - Pulling Data...');
        $modelAddedCounter = 0;
        $modelUpdatedCounter = 0;
        $v2Models = V2SystemUserType::get();
        $this->info('Pulling Roles from Scouts Digital...');
        $this->output->progressStart($v2Models->count());
        foreach ($v2Models as $v2Model) {
            $this->output->progressAdvance();
            $newModel = SsaRole::where('sd_system_user_type_id', $v2Model->id)->first();
            if (! $newModel) {
                $newModel = SsaRole::create($this->getNewModelData($v2Model));
                $this->updateRolePermissions($newModel, $v2Model);
                $modelAddedCounter++;
                Log::info('ScoutsDigitalPullRoles - Added new model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);
                $this->info("Users: Added New Role: [{$newModel->getKey()}] {$newModel->name}", 'vvv');

                // Handle Role Permissions here too

                continue;
            }
            if ($newModel->updated_at < $v2Model->modified) {
                $newModel->update($this->getNewModelData($v2Model));
                $modelUpdatedCounter++;
                Log::info('ScoutsDigitalPullRoles - Updated existing Model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);
                $this->info("Users: Updated Role: [{$newModel->getKey()}] {$newModel->name}", 'vvv');

                // Handle Role Permissions here too

                continue;
            }
        }
        $this->output->progressFinish();
        Log::info('ScoutsDigitalPullRoles - Finished Pulling data!', ['models_added' => $modelAddedCounter, 'models_updated' => $modelUpdatedCounter]);
    }

    public function getNewModelData(V2SystemUserType $v2Model): array
    {
        return [
            'sd_system_user_type_id' => $v2Model->id,
            'name' => $v2Model->name,
            'description' => $v2Model->description,

            'requires_warrant' => $v2Model->warrantedRole,

            'is_active' => $v2Model->active ?? false,
            'created_at' => $v2Model->created,
            'updated_at' => $v2Model->modified !== '0000-00-00 00:00:00' ? $v2Model->modified : null,
        ];
    }

    public function updateRolePermissions(SsaRole $ssaRole, V2SystemUserType $v2SystemUserType)
    {
        $permissions = array_filter([
            Permission::LEGACY_CAN_ADMIN_ALUMNI => $v2SystemUserType->canAdminAlumni,
            Permission::LEGACY_CAN_SEE_ALUMNI => $v2SystemUserType->canSeeAlumni,
            Permission::LEGACY_CAN_ADMIN_NATIONAL => $v2SystemUserType->canAdminNational,
            Permission::LEGACY_CAN_SEE_NATIONAL => $v2SystemUserType->canSeeNational,
            Permission::LEGACY_CAN_ADMIN_REGION => $v2SystemUserType->canAdminRegion,
            Permission::LEGACY_CAN_SEE_REGION => $v2SystemUserType->canSeeRegion,
            Permission::LEGACY_CAN_ADMIN_REGION_KIDS => $v2SystemUserType->canAdminRegionKids,
            Permission::LEGACY_CAN_ADMIN_REGION_TRAINING => $v2SystemUserType->canAdminRegionTraining,
            Permission::LEGACY_CAN_ADMIN_SUPER_DISTRICT => $v2SystemUserType->canAdminSuperDistrict,
            Permission::LEGACY_CAN_SEE_SUPER_DISTRICT => $v2SystemUserType->canSeeSuperDistrict,
            Permission::LEGACY_CAN_ADMIN_DISTRICT => $v2SystemUserType->canAdminDistrict,
            Permission::LEGACY_CAN_SEE_DISTRICT => $v2SystemUserType->canSeeDistrict,
            Permission::LEGACY_CAN_ADMIN_DISTRICT_KIDS => $v2SystemUserType->canAdminDistrictKids,
            Permission::LEGACY_CAN_ADMIN_GROUP => $v2SystemUserType->canAdminGroup,
            Permission::LEGACY_CAN_SEE_GROUP => $v2SystemUserType->canSeeGroup,
            Permission::LEGACY_CAN_ADMIN_GROUP_ADULTS => $v2SystemUserType->canAdminGroupAdults,
            Permission::LEGACY_CAN_AWARD_GROUP_MEERKATS => $v2SystemUserType->canAwardGroupMeerkats,
            Permission::LEGACY_CAN_AWARD_GROUP_CUBS => $v2SystemUserType->canAwardGroupCubs,
            Permission::LEGACY_CAN_AWARD_GROUP_SCOUTS => $v2SystemUserType->canAwardGroupScouts,
            Permission::LEGACY_CAN_AWARD_GROUP_ROVERS => $v2SystemUserType->canAwardGroupRovers,
            Permission::LEGACY_CAN_SEE_SUPPORT => $v2SystemUserType->canSeeSupport,
            Permission::LEGACY_CAN_ADMIN_SUPPORT => $v2SystemUserType->canAdminSupport,
            Permission::LEGACY_CAN_ADD_WARRANTS => $v2SystemUserType->canAddWarrants,
            Permission::LEGACY_CAN_ADMIN_PROPERTY => $v2SystemUserType->canAdminProperty,
            Permission::LEGACY_CAN_SIGN_WARRANTS => $v2SystemUserType->canSignWarrants,
            Permission::LEGACY_CAN_ADMIN_FORM29 => $v2SystemUserType->canAdminForm29,
            Permission::LEGACY_CAN_ADMIN_POLICE_CLEARANCE => $v2SystemUserType->canAdminPoliceClearance,
        ]);
        $ssaRole->permissions()->sync(Permission::whereIn('system_name', array_keys($permissions))->pluck('id')->toArray());
    }
}
