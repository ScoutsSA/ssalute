<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\BaseBadgeResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\Pages\ListRoverBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Rovers\Pages\ViewRoverBadge;
use App\Models\SystemBadgeRoversFirst;
use UnitEnum;

class RoverBadgeResource extends BaseBadgeResource
{
    protected static ?string $model = SystemBadgeRoversFirst::class;

    protected static ?string $slug = 'rover-badges';

    protected static ?string $modelLabel = 'rover badge';

    protected static ?string $pluralModelLabel = 'rover badges';

    protected static ?int $navigationSort = 40;

    protected static string|UnitEnum|null $navigationGroup = 'Rovers';

    public static function getPages(): array
    {
        return [
            'index' => ListRoverBadges::route('/'),
            'view' => ViewRoverBadge::route('/{record}'),
        ];
    }
}
