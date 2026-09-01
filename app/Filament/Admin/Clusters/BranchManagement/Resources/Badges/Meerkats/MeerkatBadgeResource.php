<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\BaseBadgeResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\Pages\ListMeerkatBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Meerkats\Pages\ViewMeerkatBadge;
use App\Models\SystemBadgeMeerkatsFirst;
use UnitEnum;

class MeerkatBadgeResource extends BaseBadgeResource
{
    protected static ?string $model = SystemBadgeMeerkatsFirst::class;

    protected static ?string $slug = 'meerkat-badges';

    protected static ?string $modelLabel = 'meerkat badge';

    protected static ?string $pluralModelLabel = 'meerkat badges';

    protected static ?int $navigationSort = 10;

    protected static string|UnitEnum|null $navigationGroup = 'Meerkats';

    public static function getPages(): array
    {
        return [
            'index' => ListMeerkatBadges::route('/'),
            'view' => ViewMeerkatBadge::route('/{record}'),
        ];
    }
}
