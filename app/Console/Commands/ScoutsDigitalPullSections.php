<?php

namespace App\Console\Commands;

use App\Constants\SectionTypes;
use App\Models\V2\V2Group;
use App\Models\V2\V2GroupsMulti;
use App\Models\V3\V3Group;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalPullSections extends Command
{
    protected $signature = 'sd:pull-sections';
    protected $description = 'Pulls sections from Scouts Digital';

    public function handle()
    {
        Log::info('ScoutsDigitalPullSections - Pulling Data...');

        $newDensCounter = 0;
        $newPacksCounter = 0;
        $newTroopsCounter = 0;
        $newCrewsCounter = 0;
        $v2Models = V2Group::get();
        $this->info('Pulling Sections from Scouts Digital...');
        $this->output->progressStart($v2Models->count());
        foreach ($v2Models as $v2Model) {
            $this->output->progressAdvance();
            $newGroup = V3Group::where('sd_group_id', $v2Model->id)->first();
            if (! $newGroup) {
                Log::error('ScoutsDigitalPullSections - V3Group not found', ['group_id' => $v2Model->getKey()]);
                $this->line(string:'', verbosity:'v');
                $this->error('Sections: V3Group not found: ' . $v2Model->name, 'v');

                continue;
            }
            $newDensCounter += $this->syncDens($newGroup, $v2Model);
            $newPacksCounter += $this->syncPacks($newGroup, $v2Model);
            $newTroopsCounter += $this->syncTroops($newGroup, $v2Model);
            $newCrewsCounter += $this->syncCrews($newGroup, $v2Model);
        }
        $this->output->progressFinish();
        Log::info('ScoutsDigitalPullSections - Finished Pulling data!', [
            'new_dens' => $newDensCounter,
            'new_packs' => $newPacksCounter,
            'new_troops' => $newTroopsCounter,
            'new_crews' => $newCrewsCounter,
        ]);
    }

    public function syncDens(V3Group $newGroup, V2Group $v2Model): int
    {
        if ($v2Model->multiDen) {
            return $this->syncMultiDens($newGroup, $v2Model);
        }
        if ($v2Model->hasMeerkats && $newGroup->dens()->count() !== 1) {
            $newModel = $newGroup->dens()->create([...$this->getNewModelData($v2Model), 'type' => SectionTypes::DEN]);
            Log::info('ScoutsDigitalPullRegions - Added new Den', ['id' => $newModel->getKey(), 'group_id' => $newGroup->getKey()]);
            $this->info("Sections: Added Den for: {$v2Model->name}", 'vvv');

            return 1;
        }

        return 0;
    }

    public function syncMultiDens(V3Group $newGroup, V2Group $v2Group): int
    {
        $multiGroups = $v2Group->v2MultiSections()->where('type', V2GroupsMulti::TYPE_MEERCAT)->get();
        if ($newGroup->dens()->count() !== $multiGroups->count()) {
            if ($newGroup->dens()->count() > 0) {
                Log::error('ScoutsDigitalPullSections - Multi Den - V3Group already has dens, but not enough for the multi den', [
                    'group_id' => $newGroup->id,
                    'group_sd_id' => $newGroup->sd_group_id,
                    'group_dens_count' => $newGroup->dens()->count(),
                    'group_multi_dens_count' => $multiGroups->count(),
                ]);
                $this->line(string:'', verbosity:'v');
                $this->error("Sections: Multi Den - V3Group already has dens, but not enough for the multi den: {$newGroup->name}", 'v');

                return 0;
            }
            foreach ($multiGroups as $multiGroup) {
                $newModel = $newGroup->dens()->create(['region_id' => $newGroup->region_id, 'district_id' => $newGroup->district_id, 'type' => SectionTypes::DEN, 'name' => $multiGroup->name, 'is_active' => $multiGroup->active, 'created_at' => $multiGroup->created]);
                Log::info('ScoutsDigitalPullRegions - Added new Multi Den', ['id' => $newModel->getKey(), 'name' => $newModel->name, 'group_id' => $newGroup->getKey(), 'sd_group_id' => $newGroup->sd_group_id]);
                $this->info("Sections: Added Multi Den for: {$v2Group->name}", 'vvv');
            }

            return $multiGroups->count();
        }

        return 0;
    }

    public function syncPacks(V3Group $newGroup, V2Group $v2Model): int
    {
        if ($v2Model->multiPack) {
            return $this->syncMultiPacks($newGroup, $v2Model);
        }
        if ($v2Model->hasCubs && $newGroup->packs()->count() !== 1) {
            $newModel = $newGroup->packs()->create([...$this->getNewModelData($v2Model), 'type' => SectionTypes::PACK]);
            Log::info('ScoutsDigitalPullRegions - Added new Pack', ['id' => $newModel->getKey(), 'group_id' => $newGroup->getKey()]);
            $this->info("Sections: Added Pack for: {$v2Model->name}", 'vvv');

            return 1;
        }

        return 0;
    }

    public function syncMultiPacks(V3Group $newGroup, V2Group $v2Group): int
    {
        $multiGroups = $v2Group->v2MultiSections()->where('type', V2GroupsMulti::TYPE_CUB)->get();
        if ($newGroup->packs()->count() !== $multiGroups->count()) {
            if ($newGroup->packs()->count() > 0) {
                Log::error('ScoutsDigitalPullSections - Multi Pack - V3Group already has packs, but not enough for the multi pack', [
                    'group_id' => $newGroup->id,
                    'group_sd_id' => $newGroup->sd_group_id,
                    'group_packs_count' => $newGroup->packs()->count(),
                    'group_multi_packs_count' => $multiGroups->count(),
                ]);
                $this->line(string:'', verbosity:'v');
                $this->error("Sections: Multi Pack - V3Group already has packs, but not enough for the multi pack: {$newGroup->name}", 'v');

                return 0;
            }
            foreach ($multiGroups as $multiGroup) {
                $newModel = $newGroup->packs()->create(['region_id' => $newGroup->region_id, 'district_id' => $newGroup->district_id, 'type' => SectionTypes::PACK, 'name' => $multiGroup->name, 'is_active' => $multiGroup->active, 'created_at' => $multiGroup->created]);
                Log::info('ScoutsDigitalPullRegions - Added new Multi Pack', ['id' => $newModel->getKey(), 'name' => $newModel->name, 'group_id' => $newGroup->getKey(), 'sd_group_id' => $newGroup->sd_group_id]);
                $this->info("Sections: Added Multi Pack for: {$v2Group->name}", 'vvv');
            }

            return $multiGroups->count();
        }

        return 0;
    }

    public function syncTroops(V3Group $newGroup, V2Group $v2Model): int
    {
        if ($v2Model->multiTroop) {
            return $this->syncMultiTroops($newGroup, $v2Model);
        }
        if ($v2Model->hasCubs && $newGroup->troops()->count() !== 1) {
            $newModel = $newGroup->troops()->create([...$this->getNewModelData($v2Model), 'type' => SectionTypes::TROOP]);
            Log::info('ScoutsDigitalPullRegions - Added new Troop', ['id' => $newModel->getKey(), 'group_id' => $newGroup->getKey()]);
            $this->info("Sections: Added Troop for: {$v2Model->name}", 'vvv');

            return 1;
        }

        return 0;
    }

    public function syncMultiTroops(V3Group $newGroup, V2Group $v2Group): int
    {
        $multiGroups = $v2Group->v2MultiSections()->where('type', V2GroupsMulti::TYPE_SCOUT)->get();
        if ($newGroup->troops()->count() !== $multiGroups->count()) {
            if ($newGroup->troops()->count() > 0) {
                Log::error('ScoutsDigitalPullSections - Multi Troop - V3Group already has troops, but not enough for the multi troop', [
                    'group_id' => $newGroup->id,
                    'group_sd_id' => $newGroup->sd_group_id,
                    'group_troops_count' => $newGroup->troops()->count(),
                    'group_multi_troops_count' => $multiGroups->count(),
                ]);
                $this->line(string:'', verbosity:'v');
                $this->error("Sections: Multi Troop - V3Group already has troops, but not enough for the multi troop: {$newGroup->name}", 'v');

                return 0;
            }
            foreach ($multiGroups as $multiGroup) {
                $newModel = $newGroup->troops()->create(['region_id' => $newGroup->region_id, 'district_id' => $newGroup->district_id, 'type' => SectionTypes::TROOP, 'name' => $multiGroup->name, 'is_active' => $multiGroup->active, 'created_at' => $multiGroup->created]);
                Log::info('ScoutsDigitalPullRegions - Added new Multi Troop', ['id' => $newModel->getKey(), 'name' => $newModel->name, 'group_id' => $newGroup->getKey(), 'sd_group_id' => $newGroup->sd_group_id]);
                $this->info("Sections: Added Multi Troop for: {$v2Group->name}", 'vvv');
            }

            return $multiGroups->count();
        }

        return 0;
    }

    public function syncCrews(V3Group $newGroup, V2Group $v2Model): int
    {
        if ($v2Model->multiCrew) {
            return $this->syncMultiCrews($newGroup, $v2Model);
        }
        if ($v2Model->hasCubs && $newGroup->crews()->count() !== 1) {
            $newModel = $newGroup->crews()->create([...$this->getNewModelData($v2Model), 'type' => SectionTypes::CREW]);
            Log::info('ScoutsDigitalPullRegions - Added new Crew', ['id' => $newModel->getKey(), 'group_id' => $newGroup->getKey()]);
            $this->info("Sections: Added Crew for: {$v2Model->name}", 'vvv');

            return 1;
        }

        return 0;
    }

    public function syncMultiCrews(V3Group $newGroup, V2Group $v2Group): int
    {
        $multiGroups = $v2Group->v2MultiSections()->where('type', V2GroupsMulti::TYPE_ROVER)->get();
        if ($newGroup->crews()->count() !== $multiGroups->count()) {
            if ($newGroup->crews()->count() > 0) {
                Log::error('ScoutsDigitalPullSections - Multi Crew - V3Group already has crews, but not enough for the multi crew', [
                    'group_id' => $newGroup->id,
                    'group_sd_id' => $newGroup->sd_group_id,
                    'group_crews_count' => $newGroup->crews()->count(),
                    'group_multi_crews_count' => $multiGroups->count(),
                ]);
                $this->line(string:'', verbosity:'v');
                $this->error("Sections: Multi Crew - V3Group already has crews, but not enough for the multi crew: {$newGroup->name}", 'v');

                return 0;
            }
            foreach ($multiGroups as $multiGroup) {
                $newModel = $newGroup->crews()->create(['region_id' => $newGroup->region_id, 'district_id' => $newGroup->district_id, 'type' => SectionTypes::CREW, 'name' => $multiGroup->name, 'is_active' => $multiGroup->active, 'created_at' => $multiGroup->created]);
                Log::info('ScoutsDigitalPullRegions - Added new Multi Crew', ['id' => $newModel->getKey(), 'name' => $newModel->name, 'group_id' => $newGroup->getKey(), 'sd_group_id' => $newGroup->sd_group_id]);
                $this->info("Sections: Added Multi Crew for: {$v2Group->name}", 'vvv');
            }

            return $multiGroups->count();
        }

        return 0;
    }

    public function getNewModelData(V2Group $v2Model): array
    {
        // Missing and type
        return [
            'region_id' => $v2Model->assoc_to_region,
            'district_id' => $v2Model->assoc_to_district,
            'is_active' => $v2Model->active,
            'created_at' => $v2Model->created,
            'updated_at' => $v2Model->modified,
        ];
    }
}
