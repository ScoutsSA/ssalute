<?php

namespace App\Providers;

use App\Models\SystemUser;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        Horizon::routeSlackNotificationsTo(config('horizon.slack_webhook_url'));
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function (?SystemUser $user = null) {
            return $user?->isSuperAdmin();
        });
    }
}
