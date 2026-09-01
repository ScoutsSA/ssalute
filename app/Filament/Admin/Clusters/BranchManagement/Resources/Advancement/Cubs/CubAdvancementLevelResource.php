<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\BaseAdvancementResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\Pages\ListCubAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Cubs\Pages\ViewCubAdvancementLevel;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\CubAreasRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\CubTasksRelationManager;
use App\Models\SystemAdvancementCubsLevel;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class CubAdvancementLevelResource extends BaseAdvancementResource
{
    protected static ?string $model = SystemAdvancementCubsLevel::class;

    protected static ?string $slug = 'cub-advancement';

    protected static ?string $modelLabel = 'cub advancement level';

    protected static ?string $pluralModelLabel = 'cub advancement levels';

    protected static ?int $navigationSort = 21;

    protected static string|UnitEnum|null $navigationGroup = 'Cubs';

    public static function getRelations(): array
    {
        return [
            CubAreasRelationManager::make(),
            CubTasksRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCubAdvancementLevels::route('/'),
            'view' => ViewCubAdvancementLevel::route('/{record}'),
        ];
    }

    protected static function levelExtraFormFields(): array
    {
        return [
            TextInput::make('colour')->label('Colour')->maxLength(25),
        ];
    }

    protected static function levelExtraInfolistEntries(): array
    {
        return [
            TextEntry::make('colour')->label('Colour')->placeholder('-'),
        ];
    }

    protected static function levelExtraTableColumns(): array
    {
        return [
            TextColumn::make('colour')->label('Colour')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
