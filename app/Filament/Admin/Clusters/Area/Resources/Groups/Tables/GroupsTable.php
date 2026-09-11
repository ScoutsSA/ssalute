<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Groups\Tables;

use App\Filament\Admin\Clusters\Area\Actions\DeleteAreaAction;
use App\Models\District;
use App\Models\Group;
use App\Models\GroupsType;
use App\Models\Region;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
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
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->description(fn (Group $record): string => "{$record->region?->name} - {$record->district?->name}")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('region.name')
                    ->label('Region')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('district.name')
                    ->label('District')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('groupRegNr')
                    ->label('Registration Number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('groupAccount.accountName')
                    ->label('Group Account')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TextColumn::make('meerkatProgramTypeLabel')
                    ->label('Meerkat Program')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cubProgramTypeLabel')
                    ->label('Cub Program')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('scoutProgramTypeLabel')
                    ->label('Scout Program')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roverProgramTypeLabel')
                    ->label('Rover Program')
                    ->toggleable(isToggledHiddenByDefault: true),

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
                TextColumn::make('created')
                    ->label('Created At')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('modified')
                    ->label('Modified At')
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('modifiedBy.name')
                    ->label('Modified By')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('groupLastUpdated')
                    ->label('Group Last Updated')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('groupTypeID')
                    ->label('Group Type')
                    ->options(fn (): array => GroupsType::query()
                        ->orderBy('name')
                        ->get()
                        ->mapWithKeys(fn (GroupsType $type): array => [$type->id => "{$type->name} (#{$type->id})"])
                        ->all()),
                SelectFilter::make('assoc_to_region')
                    ->label('Region')
                    ->options(fn (): array => Region::query()
                        ->orderBy('position')
                        ->get()
                        ->mapWithKeys(fn (Region $region): array => [$region->id => "{$region->name} (#{$region->id})"])
                        ->all())
                    ->searchable(),
                SelectFilter::make('assoc_to_district')
                    ->label('District')
                    ->options(fn (): array => District::query()
                        ->orderBy('name')
                        ->get()
                        ->mapWithKeys(fn (District $district): array => [$district->id => "{$district->name} (#{$district->id})"])
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
