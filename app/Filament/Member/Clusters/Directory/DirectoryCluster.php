<?php

namespace App\Filament\Member\Clusters\Directory;

use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class DirectoryCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Adult Leaders';

    protected static string|UnitEnum|null $navigationGroup = 'Scout Info';

    protected static ?string $clusterBreadcrumb = 'Adult Leaders';

    public static function canAccess(): bool
    {
        return resolve(FeatureSettings::class)->users_can_browse_directory;
    }
}
