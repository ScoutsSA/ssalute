<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers;

use App\Models\SystemAdvancementScoutsSecondEntshaTheme;
use App\Services\LegacyHtmlService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ScoutTasksRelationManager extends BaseAdvancementTasksRelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $title = 'Tasks';

    public function table(Table $table): Table
    {
        return parent::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->with('entshaTheme'));
    }

    protected function taskFormComponents(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
            TextInput::make('short')
                ->label('Short name')
                ->maxLength(255)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
            Textarea::make('description')
                ->rows(4)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
            Select::make('theme')
                ->label('Entsha theme')
                ->options(fn (): array => SystemAdvancementScoutsSecondEntshaTheme::query()
                    ->orderBy('themeName')
                    ->get()
                    ->mapWithKeys(fn (SystemAdvancementScoutsSecondEntshaTheme $theme): array => [
                        $theme->id => LegacyHtmlService::decode($theme->themeName) . " (#{$theme->id})",
                    ])
                    ->all())
                ->helperText('Entsha levels display the theme next to the task name.'),
            Toggle::make('campingTask')
                ->label('Camping task')
                ->inline(false),
            Toggle::make('badgeTask')
                ->label('Badge task')
                ->inline(false)
                ->helperText('Marks a task that is completed by earning badges.'),
            Toggle::make('PGATask')
                ->label('PGA task')
                ->inline(false),
            Toggle::make('active')
                ->default(true)
                ->inline(false),
        ];
    }

    protected function taskTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->searchable()
                ->wrap(),
            TextColumn::make('entshaTheme.themeName')
                ->label('Entsha Theme')
                ->state(fn ($record): string => $record->entshaTheme
                    ? LegacyHtmlService::decode($record->entshaTheme->themeName) . " (#{$record->theme})"
                    : '-')
                ->toggleable(),
            TextColumn::make('short')
                ->label('Short Name')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('description')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                ->limit(80)
                ->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('campingTask')->label('Camping Task')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('badgeTask')->label('Badge Task')->boolean()->sortable()->toggleable(),
            IconColumn::make('PGATask')->label('PGA Task')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
