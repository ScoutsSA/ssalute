<?php

namespace App\Filament\General\Clusters\Area\Resources\Districts\Schemas;

use App\Models\District;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class DistrictInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('District Details')
                    ->description(fn (District $record) => $record->name)
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('region.name')
                            ->label('Region')
                            ->icon(Heroicon::GlobeEuropeAfrica),
                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('phys_address')
                            ->label('Physical Address')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('groups_count')
                            ->label('Groups')
                            ->state(fn (District $record) => $record->groups()->count()),
                    ]),
            ]);
    }
}
