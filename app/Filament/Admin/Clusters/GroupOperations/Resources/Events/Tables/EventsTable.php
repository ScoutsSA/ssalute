<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Tables;

use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\EventResource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('eventType.name')
                    ->label('Type'),
                TextColumn::make('group.groupName')
                    ->label('Group'),
                TextColumn::make('startDate')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('endDate')
                    ->label('End Date')
                    ->date(),
                TextColumn::make('scouterResponsible.name')
                    ->label('Responsible Scouter'),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
                IconColumn::make('approved')
                    ->label('Approved')
                    ->boolean(),
                IconColumn::make('nationalEvent')
                    ->label('National')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('startDate', 'desc')
            ->recordUrl(fn ($record) => EventResource::getUrl('view', ['record' => $record]));
    }
}
