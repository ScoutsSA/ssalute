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
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_404_pages')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_bad_logons')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_banned_ips')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_good_logons')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_meerkats')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_cubs')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_scouts')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_rovers')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_scouters')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_photos')->update(['PDFLocation' => 'sanitized', 'thumbLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_documents')->update(['PDFLocation' => 'sanitized']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_award_applications')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_award_info')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_charge_info')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_criminal_check')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_documents')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_documents_groups')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_past_service_info')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_police_clearance')->update(['documentLocation' => 'sanitized']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_resign_leader')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_retire_leader')->update(['PDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_terminate_leader')->update(['PDFLocation' => 'sanitized']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_training_courses')->update(['agendaPDFLocation' => 'sanitized', 'materialPDFLocation' => 'sanitized']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_training_courses_annual_bookings')->update(['invoiceLocation' => 'sanitized', 'POPLocation' => 'sanitized', 'userPIN' => null]);



        return Command::SUCCESS;
    }
}
