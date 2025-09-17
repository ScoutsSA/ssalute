<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')
    ->name('home');

Route::get('tools/sd/check-account', \App\Livewire\Tools\CheckUserExistenceForm::class)
    ->name('tools.sd.check-account');

require __DIR__ . '/auth.php';
require __DIR__ . '/form-routes.php';
