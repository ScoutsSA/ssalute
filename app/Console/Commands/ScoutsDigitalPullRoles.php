<?php

namespace App\Console\Commands;

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
        foreach (V2SystemUserType::get() as $v2Model) {
            $newModel = SsaRole::where('sd_system_user_type_id', $v2Model->id)->first();
            if (! $newModel) {
                $newModel = SsaRole::create($this->getNewModelData($v2Model));
                $modelAddedCounter++;
                Log::info('ScoutsDigitalPullRoles - Added new model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);
                $this->info("Users: Added New Role: [{$newModel->getKey()}] {$newModel->name}");

                // Handle Role Permissions here too

                continue;
            }
            if ($newModel->updated_at < $v2Model->modified) {
                $newModel->update($this->getNewModelData($v2Model));
                $modelUpdatedCounter++;
                Log::info('ScoutsDigitalPullRoles - Updated existing Model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);
                $this->info("Users: Updated Role: [{$newModel->getKey()}] {$newModel->name}");

                // Handle Role Permissions here too

                continue;
            }
        }
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
}
