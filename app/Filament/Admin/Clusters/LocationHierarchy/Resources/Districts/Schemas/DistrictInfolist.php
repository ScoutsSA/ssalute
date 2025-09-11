<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Districts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DistrictInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('regionID')
                    ->numeric(),
                TextEntry::make('superDistrictID')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('phys_address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('countryID')
                    ->numeric(),
                TextEntry::make('active')
                    ->numeric(),
                TextEntry::make('accountID')
                    ->numeric(),
                TextEntry::make('censusDone')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created')
                    ->dateTime(),
                TextEntry::make('createdby')
                    ->numeric(),
                TextEntry::make('modified')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('modifiedby')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
