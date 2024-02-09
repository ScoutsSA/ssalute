<?php

use App\Http\Controllers\ApplicationAdultMembershipController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'scouts-digital/check-account')->name('home');
Route::get('scouts-digital/check-account', [ApplicationAdultMembershipController::class, 'checkUserExistencePage'])->name('scouts-digital.check-account');
Route::get('register/adult/aam', [ApplicationAdultMembershipController::class, 'aamRegisterPage'])->name('register.adult.aam');
Route::get('aam.approve', [ApplicationAdultMembershipController::class, 'aamRegisterPage'])->name('aam.approve');
Route::get('aam.decline', [ApplicationAdultMembershipController::class, 'aamRegisterPage'])->name('aam.decline');

Route::redirect('login', '/admin/login')->name('login');

Route::middleware('auth:web')->group(function () {
    Route::get('register/adult/aam/{aam_actionable_slug}', [ApplicationAdultMembershipController::class, 'viewAamPage'])->name('register.adult.aam.view');
});
