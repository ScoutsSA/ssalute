<?php

namespace App\Filament\General\Clusters\Area\Resources\Groups\Schemas;

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
                    ->description(fn (Group $record) => "{$record->region?->name} > {$record->district?->name} > {$record->name}")
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Section::make('General')
                            ->secondary()
                            ->compact()
                            ->columnSpan(2)
                            ->columns(['md' => 2, 'lg' => 4])
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Name'),
                                TextEntry::make('region.name')
                                    ->label('Region')
                                    ->icon(Heroicon::GlobeEuropeAfrica),
                                TextEntry::make('district.name')
                                    ->label('District')
                                    ->icon(Heroicon::Map),
                                TextEntry::make('groupTypeLabel')
                                    ->label('Group Type'),
                                TextEntry::make('groupRegNr')
                                    ->label('Registration Number')
                                    ->placeholder('-'),
                                TextEntry::make('scarf')
                                    ->label('Scarf')
                                    ->placeholder('-'),
                                TextEntry::make('description')
                                    ->label('Description')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                                TextEntry::make('phys_address')
                                    ->label('Physical Address')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                                TextEntry::make('postalAddress')
                                    ->label('Postal Address')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Contact & Social')
                            ->description(fn (Group $record) => trim($record->website . ' - ' . $record->email, ' -'))
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 2, 'md' => 3, 'lg' => 4])
                            ->columnSpan(2)
                            ->schema([
                                TextEntry::make('email')
                                    ->label('Email')
                                    ->url(fn ($state) => $state ? "mailto:{$state}" : null)
                                    ->placeholder('-'),
                                TextEntry::make('website')
                                    ->label('Website')
                                    ->url(fn ($state) => $state ?: null)
                                    ->openUrlInNewTab()
                                    ->placeholder('-'),
                                TextEntry::make('facebook')
                                    ->label('Facebook')
                                    ->url(fn ($state) => $state ?: null)
                                    ->openUrlInNewTab()
                                    ->placeholder('-'),
                                TextEntry::make('twitter')
                                    ->label('Twitter')
                                    ->url(fn ($state) => $state ?: null)
                                    ->openUrlInNewTab()
                                    ->placeholder('-'),
                                TextEntry::make('instagram')
                                    ->label('Instagram')
                                    ->url(fn ($state) => $state ?: null)
                                    ->openUrlInNewTab()
                                    ->placeholder('-'),
                                TextEntry::make('linkedin')
                                    ->label('LinkedIn')
                                    ->url(fn ($state) => $state ?: null)
                                    ->openUrlInNewTab()
                                    ->placeholder('-'),
                                TextEntry::make('youtube')
                                    ->label('YouTube')
                                    ->url(fn ($state) => $state ?: null)
                                    ->openUrlInNewTab()
                                    ->placeholder('-'),
                            ]),

                        Section::make('Sections')
                            ->description(fn (Group $record) => trim(($record->hasMeerkats ? 'Meerkats, ' : '') . ($record->hasCubs ? 'Cubs, ' : '') . ($record->hasScouts ? 'Scouts, ' : '') . ($record->hasRovers ? 'Rovers, ' : ''), ', '))
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(['sm' => 2, 'md' => 4])
                            ->columnSpan(1)
                            ->schema([
                                IconEntry::make('hasMeerkats')
                                    ->label('Meerkats')
                                    ->boolean(),
                                IconEntry::make('hasCubs')
                                    ->label('Cubs')
                                    ->boolean(),
                                IconEntry::make('hasScouts')
                                    ->label('Scouts')
                                    ->boolean(),
                                IconEntry::make('hasRovers')
                                    ->label('Rovers')
                                    ->boolean(),
                            ]),

                        Section::make('Location')
                            ->secondary()
                            ->compact()
                            ->collapsed()
                            ->columns(2)
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
                                    ->url(fn ($state) => $state ?: null)
                                    ->openUrlInNewTab()
                                    ->placeholder('-'),
                                TextEntry::make('gps_link')
                                    ->label('View on Map')
                                    ->state(fn (Group $record) => $record->gpsLat && $record->gpsLon ? 'Open in Google Maps' : null)
                                    ->url(fn (Group $record) => $record->gpsLat && $record->gpsLon
                                        ? "https://www.google.com/maps?q={$record->gpsLat},{$record->gpsLon}"
                                        : null)
                                    ->openUrlInNewTab()
                                    ->badge()
                                    ->color('primary')
                                    ->placeholder('-'),
                            ]),
                    ]),
            ]);
    }
}
