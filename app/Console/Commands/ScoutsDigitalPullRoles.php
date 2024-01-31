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
        foreach (V2SystemUserType::active()->get() as $v2Model)
        {
            $newModel = SsaRole::firstOrCreate([
                'sd_system_user_type_id' => $v2Model->id,
                'name' => $v2Model->name,
                'description' => $v2Model->description,
                'requires_warrant' => $v2Model->warrantedRole,
            ]);
            if($newModel->wasRecentlyCreated)
            {
                $modelAddedCounter ++;
                Log::info('ScoutsDigitalPullRoles - Added new data', ['id' => $newModel->getKey(), 'name' => $newModel->name ]);
            }
        }
        Log::info('ScoutsDigitalPullRoles - Finished Pulling data!', ['new_models_added' => $modelAddedCounter]);
    }

}
