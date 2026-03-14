<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Warrants\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WarrantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Warrant Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('warrantNr')->label('Warrant Nr'),
                        TextEntry::make('warrantName')->label('Name'),
                        TextEntry::make('user.name')->label('Member'),
                        TextEntry::make('warrantType.name')->label('Type'),
                        TextEntry::make('role.typeName')->label('Role'),
                        TextEntry::make('issueDate')->label('Issue Date')->date(),
                        TextEntry::make('expireDate')->label('Expiry Date')->date(),
                        IconEntry::make('active')->label('Active')->boolean(),
                        TextEntry::make('region.name')->label('Region'),
                        TextEntry::make('district.name')->label('District'),
                        TextEntry::make('group.groupName')->label('Group'),
                        TextEntry::make('cancelationNotes')->label('Cancellation Notes')->placeholder('-'),
                        TextEntry::make('cancellationType.name')->label('Cancellation Type')->placeholder('-'),
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
