<?php

namespace App\Filament\Admin\Clusters\AdminReports;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AdminReportsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Admin Reports';

    protected static ?string $clusterBreadcrumb = 'Admin Reports';
}
