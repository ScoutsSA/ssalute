<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Regions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RegionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('position')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('name')
                    ->required(),
                TextInput::make('short'),
                TextInput::make('usingAMS')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('phys_address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('countryID')
                    ->required()
                    ->numeric(),
                TextInput::make('active')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('accountID')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('censusDone')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
