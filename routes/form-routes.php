<?php

use App\Http\Controllers\Forms\ApplicationAdultMembershipController;

Route::prefix('forms')->as('forms.')->group(function () {

    // AAM - Adult Application Membership
    Route::get('aam', \App\Livewire\Forms\Aam\ApplicationAdultMemberForm::class)->name('register.adult.aam');
    Route::get('aam/approve', [ApplicationAdultMembershipController::class, 'aamRegisterPage'])->name('aam.approve');
    Route::get('aam/decline', [ApplicationAdultMembershipController::class, 'aamRegisterPage'])->name('aam.decline');
    Route::get('register/adult/aam/{aam_actionable_slug}', [ApplicationAdultMembershipController::class, 'viewAamPage'])->name('register.adult.aam.view');
});
