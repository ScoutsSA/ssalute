<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Schemas;

use App\Services\LegacyHtmlService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdvancementLevelForm
{
    /** @param array<int, \Filament\Schemas\Components\Component> $extraFields */
    public static function configure(Schema $schema, array $extraFields = []): Schema
    {
        return $schema
            ->components([
                Section::make('Level Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull()
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
                        ...$extraFields,
                        Toggle::make('highLevel')
                            ->label('High level')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Only high levels appear in the legacy advancement screens.'),
                        Toggle::make('investment')
                            ->inline(false)
                            ->helperText('Marks the level that represents investiture.'),
                        Toggle::make('active')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Deactivated levels are hidden from sign-off screens but existing awarded records keep referencing them.'),
                    ]),
            ]);
    }
}
