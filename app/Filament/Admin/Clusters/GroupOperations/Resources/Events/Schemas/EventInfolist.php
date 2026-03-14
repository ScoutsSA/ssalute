<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Event Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')->label('Name')->columnSpanFull(),
                        TextEntry::make('description')->label('Description')->columnSpanFull()->placeholder('-'),
                        TextEntry::make('eventType.name')->label('Event Type'),
                        TextEntry::make('scouterResponsible.name')->label('Responsible Scouter'),
                        TextEntry::make('startDate')->label('Start Date')->date(),
                        TextEntry::make('startTime')->label('Start Time')->placeholder('-'),
                        TextEntry::make('endDate')->label('End Date')->date()->placeholder('-'),
                        TextEntry::make('endTime')->label('End Time')->placeholder('-'),
                        IconEntry::make('active')->label('Active')->boolean(),
                        IconEntry::make('approved')->label('Approved')->boolean(),
                        IconEntry::make('nationalEvent')->label('National Event')->boolean(),
                    ]),
                Section::make('Location')
                    ->columns(['md' => 2, 'lg' => 3])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('locationName')->label('Location Name')->placeholder('-'),
                        TextEntry::make('locationAddress')->label('Location Address')->placeholder('-'),
                        TextEntry::make('region.name')->label('Region')->placeholder('-'),
                        TextEntry::make('district.name')->label('District')->placeholder('-'),
                        TextEntry::make('group.groupName')->label('Group')->placeholder('-'),
                    ]),
                Section::make('Scouting Metrics')
                    ->collapsed()
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('nightUnderCanvas')->label('Nights Under Canvas')->placeholder('-'),
                        TextEntry::make('kmHike')->label('km Hike')->placeholder('-'),
                        IconEntry::make('competition')->label('Competition')->boolean(),
                        IconEntry::make('bookingPossible')->label('Booking Possible')->boolean(),
                    ]),
                Section::make('Audit')
                    ->collapsed()
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created')->label('Created')->dateTime(),
                        TextEntry::make('createdBy.name')->label('Created By')->placeholder('-'),
                        TextEntry::make('modified')->label('Modified')->dateTime()->placeholder('-'),
                        TextEntry::make('modifiedBy.name')->label('Modified By')->placeholder('-'),
                    ]),
            ]);
    }
}
