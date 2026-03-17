<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserSuspensionsRelationManager extends RelationManager
{
    protected static string $relationship = 'suspensions';

    protected static ?string $title = 'Suspensions';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('suspendDate')
                    ->label('Suspension Date')
                    ->date(),
                TextEntry::make('suspendReason.reason')
                    ->label('Reason'),
                TextEntry::make('unsuspendDate')
                    ->label('Unsuspended At')
                    ->dateTime()
                    ->placeholder('Still suspended'),
                TextEntry::make('unsuspendedBy.name')
                    ->label('Unsuspended By')
                    ->placeholder('-'),
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
                TextColumn::make('suspendDate')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('suspendReason.reason')
                    ->label('Reason'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->state(fn ($record) => $record->unsuspendDate === null)
                    ->boolean(),
                TextColumn::make('unsuspendDate')
                    ->label('Unsuspended')
                    ->dateTime()
                    ->placeholder('Still active')
                    ->toggleable(),
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
            ])
            ->defaultSort('suspendDate', 'desc')
            ->deferFilters(false)
            ->deferColumnManager(false)
            ->recordAction(ViewAction::class)
            ->actions([
                ViewAction::make(),
            ]);
    }
}
