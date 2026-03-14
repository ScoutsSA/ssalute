<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Regions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RegionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Region Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('short')
                            ->label('Short Name'),
                        TextInput::make('position')
                            ->numeric()
                            ->default(0),
                        Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                        Toggle::make('usingAMS')
                            ->label('Using AMS')
                            ->default(false)
                            ->inline(false),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Textarea::make('phys_address')
                            ->label('Physical Address')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
