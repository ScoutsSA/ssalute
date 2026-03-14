<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Program Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('title')->label('Title')->columnSpanFull(),
                        TextEntry::make('description')->label('Description')->columnSpanFull()->placeholder('-'),
                        TextEntry::make('date')->label('Date')->date(),
                        TextEntry::make('responsibleScouter.name')->label('Responsible Scouter'),
                        TextEntry::make('region.name')->label('Region'),
                        TextEntry::make('district.name')->label('District'),
                        TextEntry::make('group.groupName')->label('Group'),
                        IconEntry::make('shared')->label('Shared')->boolean(),
                        IconEntry::make('online')->label('Online')->boolean(),
                        IconEntry::make('active')->label('Active')->boolean(),
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
