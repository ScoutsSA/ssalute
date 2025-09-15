<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Tables;

use App\Models\Group;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->description(fn (Group $record) => $record->region?->name . ' - ' . $record->district?->name)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('sdLiteOnly')
                    ->label('SD Lite')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('scarf')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('groupTypeLabel')
                    ->label('Group Type')
                    ->sortable(['groupTypeID'])
                    ->toggleable(),
                IconColumn::make('managedRegionally')
                    ->label('Managed Regionally')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('hasMeerkats')
                    ->label('Has Meerkats')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('multiDen')
                    ->label('Multi Den')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                IconColumn::make('hasCubs')
                    ->label('Has Cubs')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('multiPack')
                    ->label('Multi Pack')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                IconColumn::make('hasScouts')
                    ->label('Has Scouts')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('multiTroop')
                    ->label('Multi Troop')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                IconColumn::make('hasRovers')
                    ->label('Has Rovers')
                    ->boolean()
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('multiCrew')
                    ->label('Multi Crew')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                // Maybe have a "Has Banking info" column that checks if bankAccountName, bankName, branchName, branchCode, bankAccountNumber are filled in?
                TextColumn::make('website')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Group Email Address')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                IconColumn::make('censusDone')
                    ->label('Census Done')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('modified')
                    ->label('Modified At')
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('modifiedBy.name')
                    ->label('Modified By')
                    ->numeric()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                // Group Type Filter
                // Region Filter
                // District Filter
                // Active Filter

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
