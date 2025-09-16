<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcomePage'])
    ->name('home');

Route::get('tools/sd/check-account', \App\Livewire\Tools\CheckUserExistenceForm::class)
    ->name('tools.sd.check-account');

require __DIR__ . '/form-routes.php';
