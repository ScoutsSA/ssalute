<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Tables;

use App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\ProgramResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('group.groupName')
                    ->label('Group'),
                TextColumn::make('region.name')
                    ->label('Region')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('responsibleScouter.name')
                    ->label('Responsible Scouter'),
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                IconColumn::make('shared')
                    ->label('Shared')
                    ->boolean(),
                IconColumn::make('online')
                    ->label('Online')
                    ->boolean(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('date', 'desc')
            ->recordUrl(fn ($record) => ProgramResource::getUrl('view', ['record' => $record]));
    }
}
