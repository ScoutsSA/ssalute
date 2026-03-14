<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DisciplinaryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Disciplinary Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('user.name')->label('Member'),
                        TextEntry::make('heading.reason')->label('Heading'),
                        TextEntry::make('sanction')->label('Sanction')->placeholder('-'),
                        TextEntry::make('expireDate')->label('Expiry Date')->date()->placeholder('-'),
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
