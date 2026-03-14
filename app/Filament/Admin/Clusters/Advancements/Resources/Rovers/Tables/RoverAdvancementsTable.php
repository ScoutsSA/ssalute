<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Tables;

use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\RoverAdvancementResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoverAdvancementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('rover.name')
                    ->label('Rover')
                    ->searchable(['first_name', 'surname'])
                    ->sortable(),
                TextColumn::make('advancement.name')
                    ->label('Level'),
                TextColumn::make('advancementDate')
                    ->label('Date')
                    ->date()
                    ->sortable(),
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
            ->recordUrl(fn ($record) => RoverAdvancementResource::getUrl('view', ['record' => $record]));
    }
}
