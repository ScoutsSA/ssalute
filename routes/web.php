<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')
    ->name('home');

Route::get('tools/sd/check-account', \App\Livewire\Tools\CheckUserExistenceForm::class)
    ->name('tools.sd.check-account');

Route::get('impersonate/sd/{user}', \App\Http\Controllers\ScoutsDigitalImpersonateController::class)
    ->name('impersonate.scouts-digital')
    ->middleware(['auth', 'signed']);

Route::get('member-verification/{uuid}', \App\Http\Controllers\MembershipCertificateController::class)
    ->name('membership-certificate.show')
    ->middleware('throttle:60,1');

require __DIR__ . '/auth.php';
require __DIR__ . '/form-routes.php';
