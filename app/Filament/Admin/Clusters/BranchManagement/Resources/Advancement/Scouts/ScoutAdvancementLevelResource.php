<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\BaseAdvancementResource;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers\ScoutTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\Pages\ListScoutAdvancementLevels;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Scouts\Pages\ViewScoutAdvancementLevel;
use App\Models\SystemAdvancementScoutsLevel;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class ScoutAdvancementLevelResource extends BaseAdvancementResource
{
    protected static ?string $model = SystemAdvancementScoutsLevel::class;

    protected static ?string $slug = 'scout-advancement';

    protected static ?string $modelLabel = 'scout advancement level';

    protected static ?string $pluralModelLabel = 'scout advancement levels';

    protected static ?int $navigationSort = 31;

    protected static string|UnitEnum|null $navigationGroup = 'Scouts';

    public static function getRelations(): array
    {
        return [
            ScoutTasksRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScoutAdvancementLevels::route('/'),
            'view' => ViewScoutAdvancementLevel::route('/{record}'),
        ];
    }

    protected static function levelExtraFormFields(): array
    {
        return [
            TextInput::make('colour')->label('Colour')->maxLength(100),
            TextInput::make('htmlColor')->label('HTML Colour')->maxLength(15),
        ];
    }

    protected static function levelExtraInfolistEntries(): array
    {
        return [
            TextEntry::make('colour')->label('Colour')->placeholder('-'),
            TextEntry::make('htmlColor')->label('HTML Colour')->placeholder('-'),
        ];
    }

    protected static function levelExtraTableColumns(): array
    {
        return [
            TextColumn::make('colour')->label('Colour')->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('htmlColor')->label('HTML Colour')->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('scoutProgramTypeID')->label('Scout Program Type ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
