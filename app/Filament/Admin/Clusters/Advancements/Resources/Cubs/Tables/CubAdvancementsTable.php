<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Tables;

use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\CubAdvancementResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CubAdvancementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cub.name')
                    ->label('Cub')
                    ->searchable(['first_name', 'surname'])
                    ->sortable(),
                TextColumn::make('advancement.name')
                    ->label('Level'),
                TextColumn::make('theme.name')
                    ->label('Challenge Theme'),
                TextColumn::make('advancementDate')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('instructorsName')
                    ->label('Instructor')
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
            ->recordUrl(fn ($record) => CubAdvancementResource::getUrl('view', ['record' => $record]));
    }
}
