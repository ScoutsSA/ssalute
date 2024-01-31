<?php

namespace App\Console\Commands;

use App\Models\Region;
use App\Models\V2\V2Region;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalPullRegions extends Command
{
    protected $signature = 'sd:pull-regions';
    protected $description = 'Pulls regions from Scouts Digital';

    public function handle()
    {
        Log::info('ScoutsDigitalPullRegions - Pulling Data...');
        $modelAddedCounter = 0;
        foreach (V2Region::active()->get() as $v2Model)
        {
            $newModel = Region::firstOrCreate([
                'sd_region_id' => $v2Model->id,
                'display_order' => $v2Model->position,
                'name' => $v2Model->name,
                'short_code' => $v2Model->short,
                'active' => $v2Model->active,
            ]);
            if($newModel->wasRecentlyCreated)
            {
                $modelAddedCounter++;
                Log::info('ScoutsDigitalPullRegions - Added new model', ['id' => $newModel->getKey(), 'name' => $newModel->name ]);
            }
        }
        Log::info('ScoutsDigitalPullRegions - Finished Pulling data!', ['new_models_added' => $modelAddedCounter]);
    }
}
