<?php

namespace App\Filament\Admin\Clusters\Forms;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class FormsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
