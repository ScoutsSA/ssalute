<?php

namespace App\Filament\General\Pages;

use App\Models\Notification as LegacyNotification;
use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class Notifications extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string|null|BackedEnum $navigationIcon = Heroicon::BellAlert;

    protected static ?string $navigationLabel = 'Notifications';

    protected static ?string $title = 'Notifications';

    protected static string|UnitEnum|null $navigationGroup = 'My Info';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.general.pages.notifications';

    public static function canAccess(): bool
    {
        return resolve(FeatureSettings::class)->users_can_view_notifications;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LegacyNotification::query()
                    ->where('active', 1)
                    ->where('userID', auth()->id())
                    ->where(function (Builder $q) {
                        $q->whereNull('doNotShowBefore')
                            ->orWhere('doNotShowBefore', '<=', now());
                    })
            )
            ->defaultSort('created', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->weight('bold')
                    ->wrap(),
                TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),
                TextColumn::make('extended')
                    ->label('Details')
                    ->toggleable()
                    ->html()
                    ->wrap(),
                TextColumn::make('colour')
                    ->label('Colour')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('forType')
                    ->label('Scope')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        1 => 'Group',
                        2 => 'District',
                        3 => 'Region',
                        4 => 'National',
                        default => '-',
                    })
                    ->toggleable(),
                TextColumn::make('doNotShowBefore')
                    ->label('Show From')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('doNotShowAfter')
                    ->label('Show Until')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created')
                    ->label('Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('dismissDate')
                    ->label('Dismissed')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('title')
                    ->options(fn () => LegacyNotification::query()
                        ->where('active', 1)
                        ->where('userID', auth()->id())
                        ->distinct()
                        ->pluck('title', 'title')
                        ->sort())
                    ->searchable(),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'dismissed' => 'Dismissed',
                    ])
                    ->default('active')
                    ->query(function (Builder $query, array $data) {
                        return match ($data['value']) {
                            'active' => $query
                                ->whereNull('dismissDate')
                                ->where(function (Builder $q) {
                                    $q->whereNull('doNotShowAfter')
                                        ->orWhere('doNotShowAfter', '>=', now());
                                }),
                            'dismissed' => $query->where(function (Builder $q) {
                                $q->whereNotNull('dismissDate')
                                    ->orWhere(function (Builder $q) {
                                        $q->whereNotNull('doNotShowAfter')
                                            ->where('doNotShowAfter', '<', now());
                                    });
                            }),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                Action::make('dismiss')
                    ->label('Dismiss')
                    ->icon(Heroicon::XMark)
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(fn (LegacyNotification $record) => $record->update([
                        'dismissDate' => now(),
                        'shown' => 1,
                    ]))
                    ->hidden(fn (LegacyNotification $record) => $record->dismissDate !== null),
            ])
            ->checkIfRecordIsSelectableUsing(fn (LegacyNotification $record): bool => $record->dismissDate === null)
            ->toolbarActions([
                BulkAction::make('dismiss')
                    ->label('Dismiss Selected')
                    ->icon(Heroicon::XMark)
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->action(fn (Collection $records) => $records
                        ->filter(fn (LegacyNotification $record) => $record->dismissDate === null)
                        ->each(fn (LegacyNotification $record) => $record->update([
                            'dismissDate' => now(),
                            'shown' => 1,
                        ]))),
            ])
            ->deferFilters(false)
            ->deferColumnManager(false)
            ->paginated([10, 25, 50]);
    }
}
