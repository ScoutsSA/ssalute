<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers;

use App\Services\LegacyHtmlService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class CubAreasRelationManager extends BaseAdvancementTasksRelationManager
{
    protected static string $relationship = 'areas';

    protected static ?string $title = 'Areas';

    protected static bool $hasActiveFlag = false;

    protected function taskFormComponents(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
            Textarea::make('description')
                ->rows(4)
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
        ];
    }

    protected function taskTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                ->searchable()
                ->wrap(),
            TextColumn::make('description')
                ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                ->limit(80)
                ->toggleable(),
        ];
    }
}
