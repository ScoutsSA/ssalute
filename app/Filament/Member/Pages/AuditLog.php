<?php

namespace App\Filament\Member\Pages;

use App\Filament\Shared\Concerns\HasAuditDisplay;
use App\Models\Audit;
use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class AuditLog extends Page implements HasActions, HasSchemas, HasTable
{
    use HasAuditDisplay;
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string|null|BackedEnum $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $navigationLabel = 'Audit Log';

    protected static ?string $title = 'Audit Log';

    protected static string|UnitEnum|null $navigationGroup = 'My Info';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.member.pages.audit-log';

    public static function canAccess(): bool
    {
        return resolve(FeatureSettings::class)->users_can_view_audit_log;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Audit::query()
                    ->where('user_id', auth()->id())
            )
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
                TextColumn::make('auditable_type')
                    ->label('Model')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable()
                    ->toggleable(),
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
                SelectFilter::make('auditable_type')
                    ->label('Model')
                    ->options(fn () => Audit::query()
                        ->where('user_id', auth()->id())
                        ->distinct()
                        ->pluck('auditable_type', 'auditable_type')
                        ->map(fn ($type) => class_basename($type))
                        ->sort()),
            ])
            ->recordAction('view')
            ->recordActions([
                self::auditViewAction(),
            ])
            ->paginated([10, 25, 50]);
    }
}
