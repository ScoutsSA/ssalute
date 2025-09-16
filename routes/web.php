<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcomePage'])
    ->name('home');

Route::get('tools/sd/check-account', \App\Livewire\Tools\CheckUserExistenceForm::class)
    ->name('tools.sd.check-account');

require __DIR__ . '/form-routes.php';


Route::get('/cw-test', function () {
    Log::channel('cloudwatch')->info('CloudWatch smoke test', ['ts' => now()->toISOString()]);
    Log::getLogger()->close(); // forces handlers to flush
    return 'ok';
});
