<?php

namespace App\Filament\Member\Clusters\Area;

use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class AreaCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Browse Areas';

    public static function canAccess(): bool
    {
        return resolve(FeatureSettings::class)->users_can_browse_areas;
    }
}
