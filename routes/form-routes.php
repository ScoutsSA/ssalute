<?php

Route::prefix('forms')->as('forms.')->group(function () {

    // AAM - Adult Application Membership
    Route::get('aam', \App\Livewire\Forms\Aam\AamRequestForm::class)->name('aam.form');
    Route::get('aam/view/{aamRequest:view_slug}', \App\Livewire\Forms\Aam\AamRequestView::class)->name('aam.view');

    Route::get('aam/action/{aamRequest:action_slug}', \App\Livewire\Forms\Aam\AamRequestAction::class)
        ->middleware('auth:web')
        ->name('aam.action');
});
