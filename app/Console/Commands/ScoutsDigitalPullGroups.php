<?php

namespace App\Console\Commands;

use App\Constants\GroupTypes;
use App\Models\District;
use App\Models\Group;
use App\Models\V2\V2Group;
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
        $modelUpdatedCounter = 0;
        foreach (V2Group::get() as $v2Model) {
            $newModel = Group::where('sd_group_id', $v2Model->id)->first();
            if (! $newModel) {
                $data = $this->getNewModelData($v2Model);
                if (empty($data)) {
                    continue;
                }
                $newModel = Group::create($data);
                $modelAddedCounter++;
                Log::info('ScoutsDigitalPullGroups - Added new model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);

                continue;
            }
            if ($newModel->updated_at < $v2Model->modified) {
                $newModel->update($this->getNewModelData($v2Model));
                $modelUpdatedCounter++;
                Log::info('ScoutsDigitalPullGroups - Updated existing Model', ['old_id' => $v2Model->getKey(), 'id' => $newModel->getKey(), 'name' => $newModel->name]);

                continue;
            }
        }
        Log::info('ScoutsDigitalPullGroups - Finished Pulling data!', ['models_added' => $modelAddedCounter, 'models_updated' => $modelUpdatedCounter]);
    }

    public function getNewModelData(V2Group $v2Model): array
    {
        $socialLinks = array_filter([
            'facebook' => $v2Model->facebook,
            'twitter' => $v2Model->twitter,
            'instagram' => $v2Model->instagram,
            'linkedin' => $v2Model->linkedin,
            'pintrest' => $v2Model->pintrest,
            'youtube' => $v2Model->youtube,
            'tumblr' => $v2Model->tumblr,
        ]);

        $v2District = $v2Model->v2District;
        if ($v2District === null) {
            Log::error('ScoutsDigitalPullGroups - District not found', ['group_id' => $v2Model->getKey()]);

            return [];
        }
        $newDistrict = District::where('sd_district_id', $v2District->id)->firstOrFail();

        return  [
            'sd_group_id' => $v2Model->id,
            'region_id' => $newDistrict->region_id,
            'district_id' => $newDistrict->id,

            'type' => match ($v2Model->groupTypeID) {
                1 => GroupTypes::COMMUNITY,
                2 => GroupTypes::NGO,
                3 => GroupTypes::CHURCH,
                4 => GroupTypes::SCHOOL,
                default => GroupTypes::UNKNOWN,
            },
            'managed_regionally' => $v2Model->managedRegionally,

            'name' => $v2Model->name,
            'email' => $v2Model->email,
            'scarf' => $v2Model->scarf,
            'physical_address' => $v2Model->phys_address,
            'google_maps' => $v2Model->google_maps,
            'banking_details' => $v2Model->bankingDetails,
            'website' => $v2Model->website,

            'related_social_links' => $socialLinks,
            'created_at' => $v2Model->created,
            'updated_at' => $v2Model->modified,
        ];
    }
}
