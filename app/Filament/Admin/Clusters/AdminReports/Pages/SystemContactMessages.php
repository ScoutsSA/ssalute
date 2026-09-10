<?php

namespace App\Filament\Admin\Clusters\AdminReports\Pages;

use App\Enums\DirectoryLevel;
use App\Filament\Admin\Clusters\AdminReports\AdminReportsCluster;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\SystemContactMessage;
use App\Models\SystemUser;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Every message relayed through the member directory's "Contact via the system" action, which
 * adult leaders use to reach members who redacted their contact details.
 */
class SystemContactMessages extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $cluster = AdminReportsCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    protected static ?string $navigationLabel = 'System Contact Messages';

    protected static ?string $title = 'System Contact Messages';

    protected static ?int $navigationSort = 30;

    protected string $view = 'filament.admin.clusters.admin-reports.report';

    protected Width|string|null $maxContentWidth = Width::Full;

    private static function userLabel(?SystemUser $user): string
    {
        return $user ? "{$user->name} (#{$user->id})" : '-';
    }

    private static function searchUser(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $query) use ($search): void {
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('surname', 'like', "%{$search}%")
                ->orWhere('knownName', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(SystemContactMessage::query()->with(['sender', 'recipient']))
            ->defaultSort('sent_at', 'desc')
            ->defaultPaginationPageOption(25)
            ->description('Database table: system_contact_messages. Messages adult leaders sent from the member directory to members who redacted their contact details.')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sent_at')
                    ->label('Sent')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('sender.name')
                    ->label('Sender')
                    ->state(fn (SystemContactMessage $record): string => self::userLabel($record->sender))
                    ->url(fn (SystemContactMessage $record): ?string => $record->sender ? UserResource::getUrl('view', ['record' => $record->sender]) : null)
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->whereHas('sender', fn (Builder $query): Builder => self::searchUser($query, $search)))
                    ->toggleable(),
                TextColumn::make('recipient.name')
                    ->label('Recipient')
                    ->state(fn (SystemContactMessage $record): string => self::userLabel($record->recipient))
                    ->url(fn (SystemContactMessage $record): ?string => $record->recipient ? UserResource::getUrl('view', ['record' => $record->recipient]) : null)
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->whereHas('recipient', fn (Builder $query): Builder => self::searchUser($query, $search)))
                    ->toggleable(),
                TextColumn::make('directory_level')
                    ->label('Directory')
                    ->formatStateUsing(fn (DirectoryLevel $state): string => $state->label())
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('message')
                    ->limit(80)
                    ->tooltip(fn (SystemContactMessage $record): string => $record->message)
                    ->wrap()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('directory_level')
                    ->label('Directory')
                    ->options(collect(DirectoryLevel::cases())->mapWithKeys(fn (DirectoryLevel $level): array => [$level->value => $level->label()])->all()),
                Filter::make('sent_between')
                    ->schema([
                        DatePicker::make('from')->label('Sent from'),
                        DatePicker::make('until')->label('Sent until'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn (Builder $query, string $from): Builder => $query->whereDate('sent_at', '>=', $from))
                        ->when($data['until'] ?? null, fn (Builder $query, string $until): Builder => $query->whereDate('sent_at', '<=', $until))),
            ]);
    }
}
