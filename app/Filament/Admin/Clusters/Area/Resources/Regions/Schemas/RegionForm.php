<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Regions\Schemas;

use App\Filament\Admin\Clusters\Area\Schemas\AreaFormComponents;
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
                    ->collapsible()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('short')
                            ->label('Short Name')
                            ->maxLength(3)
                            ->unique(ignoreRecord: true),
                        TextInput::make('position')
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Sort order in lists.'),
                        AreaFormComponents::countrySelect('countryID'),
                        AreaFormComponents::accountSelect('accountID'),
                        Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                        Toggle::make('usingAMS')
                            ->label('Using AMS')
                            ->default(true)
                            ->inline(false),
                        Toggle::make('censusDone')
                            ->label('Census Done')
                            ->default(true)
                            ->inline(false),
                    ]),
                Section::make('Addresses')
                    ->collapsible()
                    ->schema([
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Textarea::make('phys_address')
                            ->label('Physical Address')
                            ->columnSpanFull(),
                    ]),
                AreaFormComponents::auditSection(hasTimestamps: false),
            ]);
    }
}
