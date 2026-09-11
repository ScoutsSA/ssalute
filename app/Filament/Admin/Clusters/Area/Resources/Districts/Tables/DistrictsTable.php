<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Districts\Tables;

use App\Filament\Admin\Clusters\Area\Actions\DeleteAreaAction;
use App\Models\District;
use App\Models\Region;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
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
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->label('Name')
                    ->description(fn (District $record): ?string => $record->region ? "{$record->region->name} (#{$record->region->id})" : null)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('region.name')
                    ->label('Region')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('superDistrict.name')
                    ->label('Super District')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phys_address')
                    ->label('Physical Address')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('countryID')
                    ->label('Country ID')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->sortable()
                    ->searchable(['first_name', 'surname'])
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('regionID')
                    ->label('Region')
                    ->options(fn (): array => Region::query()
                        ->orderBy('position')
                        ->get()
                        ->mapWithKeys(fn (Region $region): array => [$region->id => "{$region->name} (#{$region->id})"])
                        ->all())
                    ->searchable(),
                TernaryFilter::make('active'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAreaAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
