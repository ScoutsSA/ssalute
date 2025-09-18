<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Districts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('regionID')
                    ->required()
                    ->numeric(),
                TextInput::make('superDistrictID')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('phys_address')
                    ->columnSpanFull(),
                TextInput::make('countryID')
                    ->required()
                    ->numeric()
                    ->default(196),
                TextInput::make('active')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('accountID')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('censusDone')
                    ->numeric(),
                DateTimePicker::make('created')
                    ->required(),
                TextInput::make('createdby')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('modified'),
                TextInput::make('modifiedby')
                    ->numeric(),
            ]);
    }
}
