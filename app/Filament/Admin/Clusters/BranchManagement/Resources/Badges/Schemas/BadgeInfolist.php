<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Schemas;

use App\Services\LegacyHtmlService;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BadgeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Badge Details')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('id')->label('ID'),
                        TextEntry::make('name')
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state)),
                        TextEntry::make('type')->placeholder('-'),
                        IconEntry::make('active')->boolean(),
                        TextEntry::make('note')
                            ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::preview($state))
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
                Section::make('Audit')
                    ->columns(['md' => 2, 'lg' => 4])
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created')->dateTime('Y/m/d H:i')->placeholder('-'),
                        TextEntry::make('createdBy.name')->label('Created by')->placeholder('-'),
                        TextEntry::make('modified')->dateTime('Y/m/d H:i')->placeholder('-'),
                        TextEntry::make('modifiedBy.name')->label('Modified by')->placeholder('-'),
                    ]),
            ]);
    }
}
