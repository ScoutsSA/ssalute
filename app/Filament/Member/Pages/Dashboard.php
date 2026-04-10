<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;
use Filament\Panel;

class Dashboard extends FilamentDashboard
{
    protected static string $routePath = '/dashboard';

    public static function getRoutePath(Panel $panel): string
    {
        return static::$routePath;
    }
}
