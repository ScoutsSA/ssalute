<?php

namespace App\Console\Commands;

use App\Providers\AppServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SanitizeDatabase extends Command
{
    protected $signature = 'app:sanitize-database';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::connection(AppServiceProvider::DB_SD_CORE)->query();

        return Command::SUCCESS;
    }
}
