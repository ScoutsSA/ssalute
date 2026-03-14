<?php

namespace App\Providers;

use App\Auth\ScoutsDigitalUserProvider;
use App\Models\CustomDatabaseNotification;
use App\Models\SystemUser;
use Filament\Schemas\Schema as FilamentSchema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Pulse\Facades\Pulse;

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
            $model = $config['model'] ?? SystemUser::class;

            return new ScoutsDigitalUserProvider($model);
        });

        Model::automaticallyEagerLoadRelationships();
        Model::preventLazyLoading(! app()->isProduction());

        Schema::defaultStringLength(255);

        FilamentSchema::configureUsing(fn (FilamentSchema $schema) => $schema->columns(1));

        DatabaseNotification::resolveRelationUsing('databaseNotifications', function () {
            return new CustomDatabaseNotification;
        });

        Gate::define('viewPulse', fn (SystemUser $user) => $user->isSuperAdmin());

        Pulse::user(fn (SystemUser $user) => [
            'name' => $user->name,
            'extra' => $user->username,
            'avatar' => null,
        ]);

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
