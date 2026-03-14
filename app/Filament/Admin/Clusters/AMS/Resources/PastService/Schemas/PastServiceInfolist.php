<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PastService\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PastServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Past Service Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('user.name')->label('Member'),
                        TextEntry::make('serviceType.name')->label('Service Type'),
                        TextEntry::make('startDate')->label('Start Date')->date()->placeholder('-'),
                        TextEntry::make('endDate')->label('End Date')->date()->placeholder('-'),
                        IconEntry::make('active')->label('Active')->boolean(),
                        TextEntry::make('region.name')->label('Region'),
                        TextEntry::make('district.name')->label('District'),
                        TextEntry::make('group.groupName')->label('Group'),
                    ]),
                Section::make('Audit')
                    ->collapsed()
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created')->label('Created')->dateTime(),
                        TextEntry::make('createdBy.name')->label('Created By'),
                        TextEntry::make('modified')->label('Modified')->dateTime()->placeholder('-'),
                        TextEntry::make('modifiedBy.name')->label('Modified By')->placeholder('-'),
                    ]),
            ]);
    }
}
