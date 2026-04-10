<?php

namespace App\Filament\Admin\RelationManagers;

use App\Filament\Shared\Concerns\HasAuditDisplay;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AuditsRelationManager extends RelationManager
{
    use HasAuditDisplay;

    protected static string $relationship = 'performedAudits';

    protected static ?string $title = 'Audit Log';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('event')
                    ->label('Event')
                    ->badge()
                    ->color(fn (string $state) => self::auditEventColor($state))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->placeholder('System')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('auditable_type')
                    ->label('Model')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('auditable_id')
                    ->label('Record ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'restored' => 'Restored',
                    ]),
            ])
            ->recordAction('view')
            ->recordActions([
                self::auditViewAction(showUser: true),
            ])
            ->paginated([10, 25, 50]);
    }
}
