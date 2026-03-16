<?php

namespace App\Filament\General\Clusters\Area\Resources\Regions\Tables;

use App\Filament\General\Clusters\Area\Resources\Districts\DistrictResource;
use App\Models\Region;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([50])
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('short')
                    ->label('Short Name')
                    ->sortable()
                    ->toggleable(),
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
            ])
            ->deferFilters(false)
            ->deferColumnManager(false)
            ->recordUrl(fn (Region $record) => DistrictResource::getUrl('index', parameters: [
                'filters[region][value]' => $record->getKey(),
            ]));
    }
}
