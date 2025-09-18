<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Groups\Schemas;

use App\Models\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GroupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Group Details')
                    ->description(fn (Group $record) => "{$record->region->name} > {$record->district->name} > {$record->name}")
                    ->columnSpan(2)
                    ->columns(2)
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('admin_group_details')
                    ->schema([
                        Section::make('General')
                            ->secondary()
                            ->compact()
                            ->collapsible()
                            ->persistCollapsed()
                            ->id('admin_group_details')
                            ->columnSpan(2)
                            ->columns(['md' => 2, 'lg' => 4, 'xl' => 6])
                            ->schema([
                                IconEntry::make('active')
                                    ->label('Active')
                                    ->boolean(),
                                TextEntry::make('id')
                                    ->label('ID')
                                    ->numeric(),
                                TextEntry::make('region.name')
                                    ->label('Region')
                                    ->icon(Heroicon::GlobeEuropeAfrica),
                                TextEntry::make('district.name')
                                    ->label('District')
                                    ->icon(Heroicon::Map),
                                TextEntry::make('name')
                                    ->label('Name'),
                                TextEntry::make('description')
                                    ->label('Description')
                                    ->placeholder('-'),
                                TextEntry::make('groupTypeLabel')
                                    ->label('Group Type'),
                                TextEntry::make('groupRegNr')
                                    ->label('Group Registration Number')
                                    ->placeholder('-'),
                                TextEntry::make('groupAccountID')
                                    ->label('Group Account ID')
                                    ->numeric(),

                                TextEntry::make('scarf')
                                    ->label('Scarf')
                                    ->placeholder('-'),
                                TextEntry::make('phys_address')
                                    ->label('Physical Address')
                                    ->placeholder('-'),
                                TextEntry::make('postalAddress')
                                    ->label('Postal Address')
                                    ->placeholder('-'),
                            ]),

                        Section::make('Program Configuration')
                            ->description(fn (Group $record) => trim(($record->hasMeerkats ? 'Meerkats, ' : '') . ($record->hasCubs ? 'Cubs, ' : '') . ($record->hasScouts ? 'Scouts, ' : '') . ($record->hasRovers ? 'Rovers, ' : ''), ', '))
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 3])
                            ->columnSpan(1)
                            ->schema([
                                IconEntry::make('hasMeerkats')
                                    ->label('Has Meerkats')
                                    ->boolean(),
                                IconEntry::make('multiDen')
                                    ->label('Multi Den')
                                    ->boolean(),
                                TextEntry::make('meerkatProgramTypeLabel')
                                    ->label('Meerkat Program Type')
                                    ->numeric(),

                                IconEntry::make('hasCubs')
                                    ->label('Has Cubs')
                                    ->boolean()
                                    ->placeholder('-'),
                                IconEntry::make('multiPack')
                                    ->label('Multi Pack')
                                    ->boolean(),
                                TextEntry::make('cubProgramTypeLabel')
                                    ->label('Cub Program Type')
                                    ->numeric(),

                                IconEntry::make('hasScouts')
                                    ->label('Has Scouts')
                                    ->boolean()
                                    ->placeholder('-'),
                                IconEntry::make('multiTroop')
                                    ->label('Multi Troop')
                                    ->boolean(),
                                TextEntry::make('scoutProgramTypeLabel')
                                    ->label('Scout Program Type')
                                    ->numeric(),

                                IconEntry::make('hasRovers')
                                    ->label('Has Rovers')
                                    ->boolean()
                                    ->placeholder('-'),
                                IconEntry::make('multiCrew')
                                    ->label('Multi Crew')
                                    ->boolean(),
                                TextEntry::make('roverProgramTypeLabel')
                                    ->label('Rover Program Type')
                                    ->numeric(),
                            ]),
                        Section::make('System Features')
                            ->description(fn (Group $record) => trim(($record->managedRegionally ? 'Managed Regionally, ' : 'Locally Managed, ') . ($record->sdLiteOnly ? 'SD Lite Only, ' : 'Full SD, ') . ($record->censusDone ? 'Census Done, ' : ''), ', '))
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 3])
                            ->columnSpan(1)
                            ->schema([
                                IconEntry::make('managedRegionally')
                                    ->label('Managed Regionally')
                                    ->boolean(),
                                IconEntry::make('sdLiteOnly')
                                    ->label('SD Lite Only')
                                    ->boolean(),
                                IconEntry::make('censusDone')
                                    ->label('Census Done')
                                    ->boolean()
                                    ->placeholder('-'),
                            ]),

                        Section::make('Banking Details')
                            ->description(fn (Group $record) => $record->bankInfoShort)
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('bankingDetails')
                                    ->label('Banking Details')
                                    ->placeholder('-')
                                    ->html()
                                    ->columnSpan(5),
                                TextEntry::make('bankAccountName')
                                    ->label('Account Name')
                                    ->columnSpan(2)
                                    ->placeholder('-'),
                                TextEntry::make('bankName')
                                    ->label('Bank Name')
                                    ->placeholder('-'),
                                TextEntry::make('branchName')
                                    ->label('Branch Name')
                                    ->placeholder('-'),
                                TextEntry::make('branchCode')
                                    ->label('Branch Code')
                                    ->placeholder('-'),
                                TextEntry::make('bankAccountNumber')
                                    ->label('Account Number')
                                    ->placeholder('-'),
                                TextEntry::make('invoiceNotes')
                                    ->label('Invoice Notes')
                                    ->placeholder('-')
                                    ->columnSpan(3),
                            ]),

                        Section::make('Social Media & Contact')
                            ->description(fn (Group $record) => trim($record->website . ' - ' . $record->email, ' -'))
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->placeholder('-'),
                                TextEntry::make('website')
                                    ->label('Website')
                                    ->placeholder('-'),
                                TextEntry::make('facebook')
                                    ->label('Facebook')
                                    ->placeholder('-'),
                                TextEntry::make('twitter')
                                    ->label('Twitter')
                                    ->placeholder('-'),
                                TextEntry::make('instagram')
                                    ->label('Instagram')
                                    ->placeholder('-'),
                                TextEntry::make('linkedin')
                                    ->label('LinkedIn')
                                    ->placeholder('-'),
                                TextEntry::make('youtube')
                                    ->label('YouTube')
                                    ->placeholder('-'),
                                TextEntry::make('googleplus')
                                    ->label('Google+')
                                    ->placeholder('-'),
                                TextEntry::make('pintrest')
                                    ->label('Pinterest')
                                    ->placeholder('-'),
                                TextEntry::make('tumblr')
                                    ->label('Tumblr')
                                    ->placeholder('-'),
                            ]),

                        Section::make('Location & Weather')
                            ->description(fn (Group $record) => ($record->gpsLat ? 'Lat: ' . $record->gpsLat . ' - ' : '') . ($record->gpsLon ? 'Lon: ' . $record->gpsLon : ''))
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 2, 'md' => 3])
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('gpsLat')
                                    ->label('GPS Latitude')
                                    ->placeholder('-'),
                                TextEntry::make('gpsLon')
                                    ->label('GPS Longitude')
                                    ->placeholder('-'),
                                TextEntry::make('googleMaps')
                                    ->label('Google Maps')
                                    ->placeholder('-'),
                                TextEntry::make('weatherID')
                                    ->label('Weather ID')
                                    ->placeholder('-'),
                                TextEntry::make('weatherLocationName')
                                    ->label('Weather Location Name')
                                    ->placeholder('-'),
                            ]),

                        Section::make('Changes')
                            ->description(fn (Group $record) => 'Last Modified: ' . ($record->modified ? $record->modified->diffForHumans() : 'N/A'))
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 2, 'md' => 2])
                            ->columnSpan(1)
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
                                TextEntry::make('groupLastUpdated')
                                    ->label('Group Last Updated')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('groupLastUpdatedBy')
                                    ->label('Group Last Updated By')
                                    ->numeric()
                                    ->placeholder('-'),
                            ]),
                    ]),

            ]);
    }
}
