<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers;

use App\Models\SystemAdvancementCubsChallenge;
use App\Models\SystemAdvancementCubsLevel;
use App\Models\SystemAdvancementCubsSecond;
use App\Services\LegacyHtmlService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CubTasksRelationManager extends BaseAdvancementTasksRelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $title = 'Tasks';

    public function table(Table $table): Table
    {
        return parent::table($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->with('advancementSecond'));
    }

    protected function taskFormComponents(): array
    {
        /** @var SystemAdvancementCubsLevel $level */
        $level = $this->getOwnerRecord();

        return [
            Select::make('secondID')
                ->label('Area')
                ->required()
                ->options(fn (): array => $level->areas()
                    ->get()
                    ->mapWithKeys(fn (SystemAdvancementCubsSecond $area): array => [
                        $area->id => LegacyHtmlService::decode($area->name) . " (#{$area->id})",
                    ])
                    ->all()),
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
            Select::make('challenge')
                ->options(fn (): array => SystemAdvancementCubsChallenge::query()
                    ->orderBy('name')
                    ->pluck('name', 'name')
                    ->all()),
            TextInput::make('note')
                ->maxLength(255)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
            Toggle::make('campingTask')
                ->label('Camping task')
                ->inline(false),
            Toggle::make('badgeTask')
                ->label('Badge task')
                ->inline(false)
                ->helperText('Marks a task that is completed by earning badges.'),
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
            TextColumn::make('advancementSecond.name')
                ->label('Area')
                ->state(fn ($record): string => $record->advancementSecond
                    ? LegacyHtmlService::decode($record->advancementSecond->name) . " (#{$record->secondID})"
                    : '-')
                ->toggleable(),
            TextColumn::make('challenge')->toggleable(),
            TextColumn::make('short')
                ->label('Short Name')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('description')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                ->limit(80)
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('note')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->limit(40)
                ->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('campingTask')->label('Camping Task')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('badgeTask')->label('Badge Task')->boolean()->sortable()->toggleable(),
        ];
    }
}
