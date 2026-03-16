<?php

namespace App\Filament\Admin\Clusters\LookupTables;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class LookupTablesCluster extends Cluster
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::TableCells;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Lookup Tables';

    protected static ?string $clusterBreadcrumb = 'Lookup Tables';
}
