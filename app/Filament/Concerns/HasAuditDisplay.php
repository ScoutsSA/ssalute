<?php

namespace App\Filament\Concerns;

use App\Models\Audit;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

trait HasAuditDisplay
{
    protected static function formatAuditValues(mixed $state): string
    {
        if (empty($state)) {
            return '<span class="text-gray-400">-</span>';
        }

        $values = is_string($state) ? json_decode($state, true) : $state;

        if (! is_array($values)) {
            return '<span class="text-gray-400">-</span>';
        }

        $lines = [];

        foreach ($values as $key => $value) {
            $displayValue = match (true) {
                is_null($value) => '<em>null</em>',
                is_array($value) => e(json_encode($value)),
                is_bool($value) => $value ? 'true' : 'false',
                default => e((string) $value),
            };
            $lines[] = '<strong>' . e($key) . ':</strong> ' . $displayValue;
        }

        return implode('<br>', $lines);
    }

    protected static function auditEventColor(string $state): string
    {
        return match ($state) {
            'created' => 'success',
            'updated' => 'warning',
            'deleted' => 'danger',
            'restored' => 'info',
            default => 'gray',
        };
    }

    protected static function auditViewAction(bool $showUser = false): Action
    {
        return Action::make('view')
            ->icon(Heroicon::Eye)
            ->color('gray')
            ->modalHeading(fn (Audit $record) => ucfirst($record->event) . ' — ' . class_basename($record->auditable_type))
            ->schema([
                Section::make('Change Details')
                    ->collapsible()
                    ->columns(2)
                    ->schema(array_filter([
                        TextEntry::make('event')
                            ->label('Event')
                            ->badge()
                            ->color(fn ($state) => self::auditEventColor($state)),
                        $showUser ? TextEntry::make('user.name')
                            ->label('User')
                            ->placeholder('System') : null,
                        TextEntry::make('auditable_type')
                            ->label('Model')
                            ->formatStateUsing(fn ($state) => class_basename($state)),
                        TextEntry::make('auditable_id')
                            ->label('Record ID'),
                        TextEntry::make('created_at')
                            ->label('Date')
                            ->dateTime(),
                    ])),
                Section::make('Values')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('old_values_display')
                            ->label('Old Values')
                            ->getStateUsing(fn (Audit $record) => self::formatAuditValues($record->old_values))
                            ->html()
                            ->placeholder('-'),
                        TextEntry::make('new_values_display')
                            ->label('New Values')
                            ->getStateUsing(fn (Audit $record) => self::formatAuditValues($record->new_values))
                            ->html()
                            ->placeholder('-'),
                    ]),
                Section::make('Request Details')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('url')
                            ->label('URL')
                            ->placeholder('-'),
                        TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('-'),
                        TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('tags')
                            ->label('Tags')
                            ->placeholder('-'),
                    ]),
            ])
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close');
    }
}
