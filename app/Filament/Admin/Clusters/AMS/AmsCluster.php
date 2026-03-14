<?php

namespace App\Filament\Admin\Clusters\AMS;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AmsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string|UnitEnum|null $navigationGroup = 'Adult Members';

    protected static ?int $navigationSort = 1;
}
