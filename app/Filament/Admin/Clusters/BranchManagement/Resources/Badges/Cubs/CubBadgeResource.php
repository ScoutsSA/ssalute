<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\BaseBadgeResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\Pages\ListCubBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Cubs\Pages\ViewCubBadge;
use App\Models\SystemBadgeCubsFirst;
use UnitEnum;

class CubBadgeResource extends BaseBadgeResource
{
    protected static ?string $model = SystemBadgeCubsFirst::class;

    protected static ?string $slug = 'cub-badges';

    protected static ?string $modelLabel = 'cub badge';

    protected static ?string $pluralModelLabel = 'cub badges';

    protected static ?int $navigationSort = 20;

    protected static string|UnitEnum|null $navigationGroup = 'Cubs';

    public static function getPages(): array
    {
        return [
            'index' => ListCubBadges::route('/'),
            'view' => ViewCubBadge::route('/{record}'),
        ];
    }
}
