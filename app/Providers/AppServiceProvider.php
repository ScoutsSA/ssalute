<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
