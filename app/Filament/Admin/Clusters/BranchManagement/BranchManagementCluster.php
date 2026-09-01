<?php

namespace App\Filament\Admin\Clusters\BranchManagement;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class BranchManagementCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Squares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Youth';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Branch Management';

    protected static ?string $clusterBreadcrumb = 'Branch Management';
}
