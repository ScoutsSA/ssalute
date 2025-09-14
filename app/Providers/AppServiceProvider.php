<?php

namespace App\Providers;

use App\Auth\ScoutsDigitalUserProvider;
use App\Models\SystemUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public const DB_SD_CORE = 'sd-core';

    public function register(): void
    {
        $this->app->bind(Authenticatable::class, SystemUser::class);
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

        Schema::defaultStringLength(255);

        if (config('app.sql_log')) {
            DB::listen(function ($query) {
                Log::info(
                    "time:{$query->time} | " . Str::replaceArray('?', $query->bindings, $query->sql),
                    ['time' => $query->time]
                );
            });
        }

    }
}
