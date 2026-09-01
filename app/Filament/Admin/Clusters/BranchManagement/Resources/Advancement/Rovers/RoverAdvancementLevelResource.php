<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\BaseAdvancementResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\RoverTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\Pages\ListRoverAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Rovers\Pages\ViewRoverAdvancementLevel;
use App\Models\SystemAdvancementRoversLevel;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class RoverAdvancementLevelResource extends BaseAdvancementResource
{
    protected static ?string $model = SystemAdvancementRoversLevel::class;

    protected static ?string $slug = 'rover-advancement';

    protected static ?string $modelLabel = 'rover advancement level';

    protected static ?string $pluralModelLabel = 'rover advancement levels';

    protected static ?int $navigationSort = 41;

    protected static string|UnitEnum|null $navigationGroup = 'Rovers';

    public static function getRelations(): array
    {
        return [
            RoverTasksRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoverAdvancementLevels::route('/'),
            'view' => ViewRoverAdvancementLevel::route('/{record}'),
        ];
    }

    protected static function levelExtraFormFields(): array
    {
        return [
            TextInput::make('htmlColor')->label('HTML Colour')->maxLength(25),
        ];
    }

    protected static function levelExtraInfolistEntries(): array
    {
        return [
            TextEntry::make('htmlColor')->label('HTML Colour')->placeholder('-'),
        ];
    }

    protected static function levelExtraTableColumns(): array
    {
        return [
            TextColumn::make('htmlColor')->label('HTML Colour')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
