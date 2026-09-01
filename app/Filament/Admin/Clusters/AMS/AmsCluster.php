<?php

namespace App\Filament\Admin\Clusters\AMS;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AmsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'UserData';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Adults';

    protected static ?string $clusterBreadcrumb = 'Adults';
}
