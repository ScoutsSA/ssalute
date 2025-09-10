<?php

namespace App\Providers;

use App\Auth\ScoutsDigitalUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const DB_SD_CORE = 'sd-core';

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom user provider for Scouts Digital AES-backed passwords
        Auth::provider('scouts_digital', function ($app, array $config) {
            $model = $config['model'] ?? \App\Models\SystemUser::class;

            return new ScoutsDigitalUserProvider($model);
        });
    }
}
