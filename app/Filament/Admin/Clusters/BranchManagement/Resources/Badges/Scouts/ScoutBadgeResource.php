<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\BaseBadgeResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\RelationManagers\AutoSignOffTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\Pages\ListScoutBadges;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Scouts\Pages\ViewScoutBadge;
use App\Models\SystemBadgeScoutsFirst;
use UnitEnum;

class ScoutBadgeResource extends BaseBadgeResource
{
    protected static ?string $model = SystemBadgeScoutsFirst::class;

    protected static ?string $slug = 'scout-badges';

    protected static ?string $modelLabel = 'scout badge';

    protected static ?string $pluralModelLabel = 'scout badges';

    protected static ?int $navigationSort = 30;

    protected static string|UnitEnum|null $navigationGroup = 'Scouts';

    public static function getRelations(): array
    {
        return array_merge(parent::getRelations(), [
            AutoSignOffTasksRelationManager::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScoutBadges::route('/'),
            'view' => ViewScoutBadge::route('/{record}'),
        ];
    }
}
