<?php

namespace App\Filament\Admin\Clusters\Area;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AreaCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string|UnitEnum|null $navigationGroup = 'Area';

    protected static ?int $navigationSort = 1;
}
