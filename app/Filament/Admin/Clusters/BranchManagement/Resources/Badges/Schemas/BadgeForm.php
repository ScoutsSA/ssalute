<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Schemas;

use App\Services\LegacyHtmlService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BadgeForm
{
    /**
     * Badge types seen in the legacy add form plus the extra values present in
     * the live catalogue data (Awareness, Rover Award).
     */
    public const array TYPES = [
        'Award',
        'Awareness',
        'Challenge',
        'Course',
        'Interest',
        'Rover Award',
        'ScoutCraft',
        'SDG',
        'Special',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Badge Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state)),
                        Select::make('type')
                            ->required()
                            ->options(array_combine(self::TYPES, self::TYPES)),
                        Textarea::make('note')
                            ->rows(4)
                            ->columnSpanFull()
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::normalize($state))
                            ->helperText('Shown to leaders when browsing the badge catalogue.'),
                        Toggle::make('active')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Deactivated badges are hidden from awarding screens but existing awarded records keep referencing them.'),
                    ]),
            ]);
    }
}
