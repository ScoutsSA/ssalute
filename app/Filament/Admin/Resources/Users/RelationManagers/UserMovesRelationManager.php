<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserMovesRelationManager extends RelationManager
{
    protected static string $relationship = 'adultLeaderMoves';

    protected static ?string $title = 'Move History';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('effectiveDate')
                    ->label('Effective Date')
                    ->date(),
                TextEntry::make('fromPosition.name')
                    ->label('From Role')
                    ->placeholder('-'),
                TextEntry::make('toPosition.name')
                    ->label('To Role')
                    ->placeholder('-'),
                TextEntry::make('fromGroupModel.name')
                    ->label('From Group')
                    ->placeholder('-'),
                TextEntry::make('toGroupModel.name')
                    ->label('To Group')
                    ->placeholder('-'),
                TextEntry::make('fromDistrictModel.name')
                    ->label('From District')
                    ->placeholder('-'),
                TextEntry::make('toDistrictModel.name')
                    ->label('To District')
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
                TextColumn::make('effectiveDate')
                    ->label('Effective Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('fromPosition.name')
                    ->label('From Role')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('toPosition.name')
                    ->label('To Role')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('fromGroupModel.name')
                    ->label('From Group')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('toGroupModel.name')
                    ->label('To Group')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('fromDistrictModel.name')
                    ->label('From District')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('toDistrictModel.name')
                    ->label('To District')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')
                    ->label('Recorded')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('effectiveDate', 'desc')
            ->recordAction(ViewAction::class)
            ->actions([
                ViewAction::make(),
            ]);
    }
}
