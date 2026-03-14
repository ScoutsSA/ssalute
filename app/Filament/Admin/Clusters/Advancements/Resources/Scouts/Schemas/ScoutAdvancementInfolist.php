<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ScoutAdvancementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Advancement Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('scout.name')->label('Scout'),
                        TextEntry::make('user.name')->label('Instructor'),
                        TextEntry::make('advancement.name')->label('Level'),
                        TextEntry::make('advancementDate')->label('Date')->date(),
                        TextEntry::make('approvedBy.name')->label('Approved By')->placeholder('-'),
                        TextEntry::make('approvedDate')->label('Approved Date')->dateTime()->placeholder('-'),
                        IconEntry::make('latest')->label('Latest')->boolean(),
                        IconEntry::make('active')->label('Active')->boolean(),
                        TextEntry::make('region.name')->label('Region'),
                        TextEntry::make('district.name')->label('District'),
                        TextEntry::make('group.groupName')->label('Group'),
                        TextEntry::make('notes')->label('Notes')->placeholder('-')->columnSpanFull(),
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
