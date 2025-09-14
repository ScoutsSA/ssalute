<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\Schemas;

use App\Models\Region;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Region Details')
                    ->description(fn (Region $record) => "Name: {$record->name}")
                    ->columns(['md' => 2, 'lg' => 4, 'xl' => 6])
                    ->collapsed()
                    ->persistCollapsed()
                    ->id('admin_region_details')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID')
                            ->numeric(),
                        TextEntry::make('position')
                            ->label('Position')
                            ->helperText("I think this is for a sort order, but don't think it's used")
                            ->numeric(),
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('short')
                            ->label('Short Name'),
                        IconEntry::make('usingAMS')
                            ->label('Using AMS')
                            ->helperText('Deprecated - all regions should be using AMS')
                            ->boolean(),
                        TextEntry::make('description')
                            ->label('Description'),
                        TextEntry::make('phys_address')
                            ->label('Physical Address'),
                        TextEntry::make('countryID')
                            ->label('Country ID')
                            ->helperText('Deprecated - no multi-country support')
                            ->numeric(),
                        IconEntry::make('active')
                            ->label('Active')
                            ->helperText('Deprecated - all regions should be active')
                            ->boolean(),
                        TextEntry::make('accountID')
                            ->label('Account ID')
                            ->helperText("Deprecated - Regions don't ever have accounts")
                            ->numeric(),
                        IconEntry::make('censusDone')
                            ->label('Census Done')
                            ->helperText('Not sure if this is used, surely it should be per year, not a single flag')
                            ->boolean(),
                    ]),
            ]);
    }
}
