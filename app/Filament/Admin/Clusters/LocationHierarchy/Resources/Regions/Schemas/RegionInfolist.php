<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RegionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('position')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('short')
                    ->placeholder('-'),
                TextEntry::make('usingAMS')
                    ->numeric(),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('phys_address')
                    ->columnSpanFull(),
                TextEntry::make('countryID')
                    ->numeric(),
                TextEntry::make('active')
                    ->numeric(),
                TextEntry::make('accountID')
                    ->numeric(),
                TextEntry::make('censusDone')
                    ->numeric(),
            ]);
    }
}
