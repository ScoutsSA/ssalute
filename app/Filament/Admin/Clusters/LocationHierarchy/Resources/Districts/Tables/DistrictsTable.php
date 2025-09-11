<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DistrictsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('regionID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('superDistrictID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('countryID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('active')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('accountID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('censusDone')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('createdby')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('modified')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('modifiedby')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
