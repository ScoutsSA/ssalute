<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Tables;

use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\ScoutAdvancementResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ScoutAdvancementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('scout.name')
                    ->label('Scout')
                    ->searchable(['first_name', 'surname'])
                    ->sortable(),
                TextColumn::make('advancement.name')
                    ->label('Level'),
                TextColumn::make('advancementDate')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('approvedBy.name')
                    ->label('Approved By')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('latest')
                    ->label('Latest')
                    ->boolean(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('group.groupName')
                    ->label('Group')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('advancementDate', 'desc')
            ->recordUrl(fn ($record) => ScoutAdvancementResource::getUrl('view', ['record' => $record]));
    }
}
