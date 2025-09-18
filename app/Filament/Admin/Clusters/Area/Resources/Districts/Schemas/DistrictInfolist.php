<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Districts\Schemas;

use App\Models\District;
use Filament\Infolists\Components\IconEntry;
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
                    ->description(fn (District $record) => "Name: {$record->name}")
                    ->columns(['md' => 2, 'lg' => 4, 'xl' => 6])
                    ->collapsed()
                    ->persistCollapsed()
                    ->id('admin_district_details')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID')
                            ->numeric(),
                        TextEntry::make('region.name')
                            ->label('Region')
                            ->icon(Heroicon::GlobeEuropeAfrica)
                            ->numeric(),
                        TextEntry::make('superDistrictID')
                            ->label('Super District ID')
                            ->helperText('ShouldBeRemoved - no super-districts in current system?')
                            ->numeric(),
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-'),
                        TextEntry::make('phys_address')
                            ->label('Physical Address')
                            ->placeholder('-'),
                        TextEntry::make('countryID')
                            ->label('Country ID')
                            ->helperText('ShouldBeRemoved - no multi-country support')
                            ->numeric(),
                        IconEntry::make('active')
                            ->label('Active')
                            ->boolean(),
                        TextEntry::make('accountID')
                            ->label('Account ID')
                            ->helperText('Primary owned account ID for this district')
                            ->numeric(),
                        IconEntry::make('censusDone')
                            ->label('Census Done')
                            ->helperText('Not sure if this is used, surely it should be per year, not a single flag')
                            ->boolean(),
                        Section::make('Changes')
                            ->columnSpan(2)
                            ->columns(['sm' => 1, 'md' => 2])
                            ->compact()
                            ->secondary()
                            ->schema([
                                TextEntry::make('created')
                                    ->label('Created At')
                                    ->dateTime(),
                                TextEntry::make('createdBy.name')
                                    ->label('Created By')
                                    ->numeric(),
                                TextEntry::make('modified')
                                    ->label('Modified At')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('modifiedBy.name')
                                    ->label('Modified By')
                                    ->numeric(),
                            ]),
                    ]),

            ]);
    }
}
