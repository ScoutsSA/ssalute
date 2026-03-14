<?php

namespace App\Filament\Admin\Clusters\GroupOperations;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class GroupOperationsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string|UnitEnum|null $navigationGroup = 'Group Operations';

    protected static ?int $navigationSort = 1;
}
