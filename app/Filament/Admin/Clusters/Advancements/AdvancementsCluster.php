<?php

namespace App\Filament\Admin\Clusters\Advancements;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AdvancementsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string|UnitEnum|null $navigationGroup = 'Youth';

    protected static ?int $navigationSort = 1;
}
