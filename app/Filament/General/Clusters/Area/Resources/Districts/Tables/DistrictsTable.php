<?php

namespace App\Filament\General\Clusters\Area\Resources\Districts\Tables;

use App\Filament\General\Clusters\Area\Resources\Groups\GroupResource;
use App\Models\District;
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
            ->groupingSettingsHidden()
            ->defaultGroup('region.name')
            ->groups([
                Group::make('region.name')
                    ->label('Region')
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->description(fn (District $record) => $record->region?->name)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('groups_count')
                    ->label('Groups')
                    ->counts('groups')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('region')
                    ->relationship('region', 'name', fn ($query) => $query->orderBy('position', 'asc')),
            ])
            ->deferFilters(false)
            ->deferColumnManager(false)
            ->recordUrl(fn (District $record) => GroupResource::getUrl('index', parameters: [
                'filters[region][value]' => $record->region->getKey(),
                'filters[district][value]' => $record->getKey(),
            ]));
    }
}
