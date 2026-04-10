<?php

namespace App\Filament\Admin\Resources\AuditLogs\Tables;

use App\Filament\Shared\Concerns\HasAuditDisplay;
use App\Models\Audit;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuditLogsTable
{
    use HasAuditDisplay;

    public static function configure(Table $table): Table
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
                    ->searchable(['first_name', 'surname'])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.username')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('auditable_type')
                    ->label('Model')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('auditable_id')
                    ->label('Record ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('url')
                    ->label('URL')
                    ->limit(60)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tags')
                    ->label('Tags')
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
                SelectFilter::make('auditable_type')
                    ->label('Model')
                    ->options(fn () => Audit::query()
                        ->distinct()
                        ->pluck('auditable_type', 'auditable_type')
                        ->map(fn ($type) => class_basename($type))
                        ->sort()),
                SelectFilter::make('user')
                    ->label('User')
                    ->relationship('user', 'username')
                    ->searchable(),
                Filter::make('auditable')
                    ->label('Record')
                    ->schema([
                        TextInput::make('auditable_id')
                            ->label('Record ID')
                            ->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data) => $query->when(
                        $data['auditable_id'] ?? null,
                        fn (Builder $q, $id) => $q->where('auditable_id', $id),
                    )),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->paginated([10, 25, 50, 100]);
    }
}
