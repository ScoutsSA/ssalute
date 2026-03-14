<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Districts\Schemas;

use App\Models\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('District Details')
                    ->columns(2)
                    ->schema([
                        Select::make('regionID')
                            ->label('Region')
                            ->options(fn () => Region::query()->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('name')
                            ->required(),
                        Toggle::make('active')
                            ->label('Active')
                            ->default(true)
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
