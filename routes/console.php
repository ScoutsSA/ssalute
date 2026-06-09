<?php

use App\Console\Commands\RunSystemFixes;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(RunSystemFixes::class)
    ->dailyAt('04:00')
    ->timezone('Africa/Johannesburg')
    ->withoutOverlapping();
