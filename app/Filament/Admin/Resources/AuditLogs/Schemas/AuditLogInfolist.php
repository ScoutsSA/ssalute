<?php

namespace App\Filament\Admin\Resources\AuditLogs\Schemas;

use App\Filament\Concerns\HasAuditDisplay;
use App\Models\Audit;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AuditLogInfolist
{
    use HasAuditDisplay;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Change Details')
                    ->collapsible()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('event')
                            ->label('Event')
                            ->badge()
                            ->color(fn ($state) => self::auditEventColor($state)),
                        TextEntry::make('user.name')
                            ->label('User')
                            ->placeholder('System'),
                        TextEntry::make('user.username')
                            ->label('Email')
                            ->placeholder('-'),
                        TextEntry::make('auditable_type')
                            ->label('Model')
                            ->formatStateUsing(fn ($state) => class_basename($state)),
                        TextEntry::make('auditable_id')
                            ->label('Record ID'),
                        TextEntry::make('created_at')
                            ->label('Date')
                            ->dateTime(),
                    ]),

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
            ]);
    }
}
