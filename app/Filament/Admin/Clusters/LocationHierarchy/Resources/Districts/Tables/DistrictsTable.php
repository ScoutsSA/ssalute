<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Tables;

use App\Models\District;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class DistrictsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated(['10', '20', '50'])
            ->groupingDirectionSettingHidden()
            ->groupingSettingsInDropdownOnDesktop()
            ->groups([
                Group::make('region.name')
                    ->label('Region')
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->description(fn (District $record) => $record->region?->name)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('ownedAccount.accountName')
                    ->label('Account')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('censusDone')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                TextColumn::make('created')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->numeric()
                    ->sortable()
                    ->searchable(['first_name', 'surname'])
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('modified')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('modifiedBy.name')
                    ->label('Updated By')
                    ->numeric()
                    ->sortable()
                    ->searchable(['first_name', 'surname'])
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make('region')
                    ->relationship('region', 'name', fn ($query) => $query->orderBy('position', 'asc')),

            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
