<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Shared\Concerns\HasAuditDisplay;
use App\Models\Audit;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

/**
 * The ten most recent audited record changes across the platform. The audit
 * log already captures every create, update and delete made through Ssalute,
 * so this is the record updates feed the legacy dashboard never had.
 */
class RecentUpdatesWidget extends TableWidget
{
    use HasAuditDisplay;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Record Updates')
            ->query(fn (): Builder => Audit::query()
                ->with('user')
                ->latest('created_at')
                ->limit(10))
            ->paginated(false)
            ->columns([
                TextColumn::make('created_at')
                    ->label('When')
                    ->since(),
                TextColumn::make('user.name')
                    ->label('By')
                    ->placeholder('System'),
                TextColumn::make('event')
                    ->badge()
                    ->color(fn (string $state) => self::auditEventColor($state)),
                TextColumn::make('auditable_type')
                    ->label('Record')
                    ->state(fn (Audit $record): string => class_basename((string) $record->auditable_type) . " (#{$record->auditable_id})"),
            ])
            ->recordAction('view')
            ->recordActions([
                self::auditViewAction(showUser: true),
            ]);
    }
}
