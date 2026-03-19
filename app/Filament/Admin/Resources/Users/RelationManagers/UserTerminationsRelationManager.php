<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserTerminationsRelationManager extends RelationManager
{
    protected static string $relationship = 'terminations';

    protected static ?string $title = 'Terminations';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('terminateDate')
                    ->label('Termination Date')
                    ->date(),
                TextEntry::make('terminateReason.reason')
                    ->label('Reason'),
                TextEntry::make('region.name')
                    ->label('Region')
                    ->placeholder('-'),
                TextEntry::make('district.name')
                    ->label('District')
                    ->placeholder('-'),
                TextEntry::make('group.name')
                    ->label('Group')
                    ->placeholder('-'),
                TextEntry::make('created')
                    ->label('Recorded At')
                    ->dateTime(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('terminateDate')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('terminateReason.reason')
                    ->label('Reason'),
                TextColumn::make('region.name')
                    ->label('Region')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('district.name')
                    ->label('District')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('group.name')
                    ->label('Group')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')
                    ->label('Recorded')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('terminateDate', 'desc')
            ->recordAction(ViewAction::class)
            ->actions([
                ViewAction::make(),
            ]);
    }
}
