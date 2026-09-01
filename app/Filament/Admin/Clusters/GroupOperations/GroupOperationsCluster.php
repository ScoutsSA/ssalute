<?php

namespace App\Filament\Admin\Clusters\GroupOperations;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class GroupOperationsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

    protected static string|UnitEnum|null $navigationGroup = 'UserData';

    protected static ?int $navigationSort = 3;
}
