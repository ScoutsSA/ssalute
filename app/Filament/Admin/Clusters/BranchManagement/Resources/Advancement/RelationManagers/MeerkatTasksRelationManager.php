<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers;

use App\Services\LegacyHtmlService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class MeerkatTasksRelationManager extends BaseAdvancementTasksRelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $title = 'Tasks';

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
            TextColumn::make('short')
                ->label('Short Name')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('description')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                ->limit(80)
                ->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('badgeTask')->label('Badge Task')->boolean()->sortable()->toggleable(),
        ];
    }
}
