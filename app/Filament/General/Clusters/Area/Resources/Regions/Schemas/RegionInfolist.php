<?php

namespace App\Filament\General\Clusters\Area\Resources\Regions\Schemas;

use App\Models\Region;
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
                    ->description(fn (Region $record) => $record->name)
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('short')
                            ->label('Short Name'),
                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('phys_address')
                            ->label('Physical Address')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('districts_count')
                            ->label('Districts')
                            ->state(fn (Region $record) => $record->districts()->count()),
                        TextEntry::make('groups_count')
                            ->label('Groups')
                            ->state(fn (Region $record) => $record->groups()->count()),
                    ]),
            ]);
    }
}
