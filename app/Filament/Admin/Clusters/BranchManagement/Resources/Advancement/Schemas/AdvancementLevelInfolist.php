<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Schemas;

use App\Services\LegacyHtmlService;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdvancementLevelInfolist
{
    /** @param array<int, \Filament\Schemas\Components\Component> $extraEntries */
    public static function configure(Schema $schema, array $extraEntries = []): Schema
    {
        return $schema
            ->components([
                Section::make('Level Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('id')->label('ID'),
                        TextEntry::make('name')
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state)),
                        TextEntry::make('position'),
                        IconEntry::make('active')->boolean(),
                        IconEntry::make('highLevel')->label('High level')->boolean(),
                        IconEntry::make('investment')->boolean(),
                        ...$extraEntries,
                        TextEntry::make('description')
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
