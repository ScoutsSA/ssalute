<?php

namespace App\Console\Commands;

use App\Models\District;
use App\Models\Region;
use App\Models\V2\V2District;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalPullDistricts extends Command
{
    protected $signature = 'sd:pull-districts';
    protected $description = 'Pulls districts from Scouts Digital';

    public function handle()
    {
        Log::info('ScoutsDigitalPullDistricts - Pulling Data...');
        $modelAddedCounter = 0;
        $modelUpdatedCounter = 0;
        foreach (V2District::get() as $v2Model) {
            $newModel = District::where('sd_district_id', $v2Model->id)->first();
            if (! $newModel) {
                $newModel = District::create($this->getNewModelData($v2Model));
                $modelAddedCounter++;
                Log::info('ScoutsDigitalPullDistricts - Added new model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);

                continue;
            }
            if ($newModel->updated_at < $v2Model->modified) {
                $newModel->update($this->getNewModelData($v2Model));
                $modelUpdatedCounter++;
                Log::info('ScoutsDigitalPullDistricts - Updated existing Model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);

                continue;
            }
        }
        Log::info('ScoutsDigitalPullDistricts - Finished Pulling data!', ['models_added' => $modelAddedCounter, 'models_updated' => $modelUpdatedCounter]);
    }

    public function getNewModelData(V2District $v2Model): array
    {
        $v2Region = $v2Model->v2Region;
        $newRegion = Region::where('sd_region_id', $v2Region->id)->first();

        return [
            'sd_district_id' => $v2Model->getKey(),
            'region_id' => $newRegion->getKey(),
            'name' => $v2Model->name,
            'is_active' => $v2Model->active,
            'updated_at' => $v2Model->modified,
            'created_at' => $v2Model->created,
        ];
    }
}
