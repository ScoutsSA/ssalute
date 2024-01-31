<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\Region;
use App\Models\V2\V2Group;
use App\Models\V2\V2Region;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalPullGroups extends Command
{
    protected $signature = 'sd:pull-groups';
    protected $description = 'Pulls groups from Scouts Digital';

    public function handle()
    {
        Log::info('ScoutsDigitalPullGroups - Pulling Data...');
        $modelAddedCounter = 0;
        foreach (V2Group::active()->get() as $v2Model)
        {
            $newModel = Group::firstOrCreate([
                    // ToDo
            ]);
            if($newModel->wasRecentlyCreated)
            {
                $modelAddedCounter++;
                Log::info('ScoutsDigitalPullGroups - Added new model', ['id' => $newModel->getKey(), 'name' => $newModel->name ]);
            }
        }
        Log::info('ScoutsDigitalPullGroups - Finished Pulling data!', ['new_models_added' => $modelAddedCounter]);
    }
}
