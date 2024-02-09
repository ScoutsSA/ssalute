<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalPullAllData extends Command
{
    protected $signature = 'sd:pull-all';
    protected $description = 'Pulls region/district/group/section/user/user_role from Scouts Digital';

    public function handle()
    {
        Log::info('ScoutsDigitalPullAllData - Pulling Data...');
        $this->call(ScoutsDigitalPullRegions::class);
        $this->call(ScoutsDigitalPullDistricts::class);
        $this->call(ScoutsDigitalPullGroups::class);
        $this->call(ScoutsDigitalPullSections::class);
        $this->call(ScoutsDigitalPullRoles::class);
        $this->call(ScoutsDigitalPullUsers::class);
        //$this->call(ScoutsDigitalPullUserRoles::class);
        Log::info('ScoutsDigitalPullAllData - Finished Pulling data!');
    }
}
