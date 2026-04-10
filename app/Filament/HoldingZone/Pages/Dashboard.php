<?php

namespace App\Filament\HoldingZone\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected static BackedEnum|string|null $navigationIcon = Heroicon::Home;

    protected static ?string $title = 'Dashboard';
}
