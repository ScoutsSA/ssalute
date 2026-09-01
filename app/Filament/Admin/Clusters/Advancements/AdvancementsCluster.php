<?php

namespace App\Filament\Admin\Clusters\Advancements;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AdvancementsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    protected static string|UnitEnum|null $navigationGroup = 'UserData';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Youth';

    protected static ?string $clusterBreadcrumb = 'Youth';
}
