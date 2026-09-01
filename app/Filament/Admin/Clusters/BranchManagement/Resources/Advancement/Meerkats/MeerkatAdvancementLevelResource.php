<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\BaseAdvancementResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\Pages\ListMeerkatAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Meerkats\Pages\ViewMeerkatAdvancementLevel;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\MeerkatTasksRelationManager;
use App\Models\SystemAdvancementMeerkatsLevel;
use UnitEnum;

class MeerkatAdvancementLevelResource extends BaseAdvancementResource
{
    protected static ?string $model = SystemAdvancementMeerkatsLevel::class;

    protected static ?string $slug = 'meerkat-advancement';

    protected static ?string $modelLabel = 'meerkat advancement level';

    protected static ?string $pluralModelLabel = 'meerkat advancement levels';

    protected static ?int $navigationSort = 11;

    protected static string|UnitEnum|null $navigationGroup = 'Meerkats';

    public static function getRelations(): array
    {
        return [
            MeerkatTasksRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeerkatAdvancementLevels::route('/'),
            'view' => ViewMeerkatAdvancementLevel::route('/{record}'),
        ];
    }
}
