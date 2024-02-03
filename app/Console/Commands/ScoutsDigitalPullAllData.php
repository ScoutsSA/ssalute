<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalPullAllData extends Command
{
    protected $signature = 'sd:pull-all';
    protected $description = 'Pulls region/district/group/section/user/user_role from Scouts Digital';

    public function handle()
    {
        Log::info('ScoutsDigitalPullAllData - Pulling Data...');
        Artisan::call(ScoutsDigitalPullRegions::class);
        Artisan::call(ScoutsDigitalPullDistricts::class);
        Artisan::call(ScoutsDigitalPullGroups::class);
        //Artisan::call(ScoutsDigitalPullSections::class);
        //Artisan::call(ScoutsDigitalPullRoles::class);
        //Artisan::call(ScoutsDigitalPullUsers::class);
        //Artisan::call(ScoutsDigitalPullUserRoles::class);
        Log::info('ScoutsDigitalPullAllData - Finished Pulling data!');
    }
}
