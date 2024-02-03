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
        $modelUpdatedCounter = 0;
        foreach (V2Region::get() as $v2Model) {
            $newModel = Region::where('sd_region_id', $v2Model->id)->first();
            if (! $newModel) {
                $newModel = Region::create($this->getNewModelData($v2Model));
                $modelAddedCounter++;
                Log::info('ScoutsDigitalPullRegions - Added new model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);

                continue;
            }
            if ($newModel->updated_at < $v2Model->modified) {
                $newModel->update($this->getNewModelData($v2Model));
                $modelUpdatedCounter++;
                Log::info('ScoutsDigitalPullRegions - Updated model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);

                continue;
            }
        }
        Log::info('ScoutsDigitalPullRegions - Finished Pulling data!', ['models_added' => $modelAddedCounter, 'models_updated' => $modelUpdatedCounter]);
    }

    public function getNewModelData(V2Region $v2Model): array
    {
        return [
            'sd_region_id' => $v2Model->id,
            'display_order' => $v2Model->position,
            'name' => $v2Model->name,
            'short_code' => $v2Model->short,
            'is_active' => $v2Model->active,
            'updated_at' => $v2Model->modified,
            'created_at' => $v2Model->created,
        ];
    }
}
