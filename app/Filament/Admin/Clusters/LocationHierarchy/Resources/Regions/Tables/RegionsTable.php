<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('position')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('short')
                    ->searchable(),
                TextColumn::make('usingAMS')
                    ->numeric()
                    ->sortable(),
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
