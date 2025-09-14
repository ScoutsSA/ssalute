<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([50])
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('name')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('short')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('usingAMS')
                    ->label('Using AMS')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('censusDone')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('districts_count')
                    ->label('Districts')
                    ->counts('districts')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('groups_count')
                    ->label('Groups')
                    ->counts('groups')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('community_groups_count')
                    ->label('Community Groups')
                    ->counts('communityGroups')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ngo_groups_count')
                    ->label('NGO Groups')
                    ->counts('ngoGroups')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('church_groups_count')
                    ->label('Church Groups')
                    ->counts('churchGroups')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('school_groups_count')
                    ->label('School Groups')
                    ->counts('schoolGroups')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('dsd_groups_count')
                    ->label('DSD Groups')
                    ->counts('dsdGroups')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
