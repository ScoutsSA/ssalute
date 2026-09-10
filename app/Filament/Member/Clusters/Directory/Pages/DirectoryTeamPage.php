<?php

namespace App\Filament\Member\Clusters\Directory\Pages;

use App\Enums\DirectoryLevel;
use App\Filament\Member\Clusters\Directory\DirectoryCluster;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Services\LegacyHtmlService;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * One team listing of the member directory: active role attachments of active members whose role
 * type carries this level's flag. Every member may browse roles and names. Contact details are
 * only queried for adult leaders (SystemUser::isAdultLeader()): for anyone else the user columns
 * holding email and cell number are never selected, so they cannot reach the rendered page.
 */
abstract class DirectoryTeamPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $cluster = DirectoryCluster::class;

    protected const string REDACTED = 'Redacted';

    protected string $view = 'filament.member.clusters.directory.team';

    protected Width|string|null $maxContentWidth = Width::Full;

    public static function canAccess(): bool
    {
        return DirectoryCluster::canAccess();
    }

    public static function getNavigationLabel(): string
    {
        return static::level()->label();
    }

    public function getTitle(): string
    {
        return static::level()->label();
    }

    public function table(Table $table): Table
    {
        $contactDetailsVisible = $this->viewerCanSeeContactDetails();

        return $table
            ->query(fn (): Builder => $this->teamQuery($contactDetailsVisible))
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(50)
            ->defaultSort(fn (Builder $query) => $query
                ->orderBy('system_users.first_name')
                ->orderBy('system_users.surname'))
            ->columns([
                TextColumn::make('user_name')
                    ->label('Name')
                    ->state(fn (SystemUsersOtherRole $record): string => $record->user->name)
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->where(function (Builder $query) use ($search): void {
                        $query->where('system_users.first_name', 'like', "%{$search}%")
                            ->orWhere('system_users.surname', 'like', "%{$search}%")
                            ->orWhere('system_users.knownName', 'like', "%{$search}%");
                    }))
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->orderBy('system_users.first_name', $direction)
                        ->orderBy('system_users.surname', $direction))
                    ->toggleable(),
                TextColumn::make('role.name')
                    ->label('Role')
                    ->formatStateUsing(fn (?string $state): ?string => LegacyHtmlService::decode($state))
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query
                        ->where('system_user_types.name', 'like', "%{$search}%"))
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->orderBy('system_user_types.name', $direction))
                    ->toggleable(),
                ...$this->scopeColumns(),
                ...($contactDetailsVisible ? $this->contactColumns() : []),
            ])
            ->filters([
                $this->roleFilter(),
                ...$this->scopeFilters($this->tenant()),
            ])
            ->emptyStateHeading('No team members found')
            ->emptyStateDescription('There are no active members holding a role at this level for the selected area.');
    }

    abstract protected static function level(): DirectoryLevel;

    /**
     * @return array<BaseFilter>
     */
    abstract protected function scopeFilters(SystemUsersOtherRole $tenant): array;

    /**
     * @return array<TextColumn>
     */
    abstract protected function scopeColumns(): array;

    protected function viewerCanSeeContactDetails(): bool
    {
        /** @var SystemUser $viewer */
        $viewer = auth()->user();

        return $viewer->isAdultLeader();
    }

    protected function tenant(): SystemUsersOtherRole
    {
        /** @var SystemUsersOtherRole $tenant */
        $tenant = Filament::getTenant();

        return $tenant;
    }

    /**
     * Legacy hides the cell number for a handful of national office holders. Levels that need it
     * override this hook.
     */
    protected function cellNumberHiddenFor(SystemUsersOtherRole $record): bool
    {
        return false;
    }

    protected function teamQuery(bool $contactDetailsVisible): Builder
    {
        $level = static::level();

        return SystemUsersOtherRole::query()
            ->join('system_user_types', 'system_user_types.id', '=', 'system_users_other_roles.roleID')
            ->join('system_users', 'system_users.id', '=', 'system_users_other_roles.userID')
            ->select('system_users_other_roles.*')
            ->where('system_users_other_roles.active', 1)
            ->where('system_users.active', 1)
            ->where("system_user_types.{$level->roleFlagColumn()}", 1)
            ->when($level === DirectoryLevel::Group, fn (Builder $query): Builder => $query
                ->where('system_user_types.adultLeaderRole', 1))
            ->with([
                'role',
                'user' => fn ($query) => $query->select($this->userColumns($contactDetailsVisible)),
                ...$this->scopeRelations(),
            ]);
    }

    /**
     * @return array<string>
     */
    protected function scopeRelations(): array
    {
        return [];
    }

    /**
     * Role types that can appear on this level, so the options never list roles the team query
     * would exclude anyway.
     */
    private function roleFilter(): SelectFilter
    {
        $level = static::level();

        return SelectFilter::make('role')
            ->label('Role')
            ->multiple()
            ->searchable()
            ->options(fn (): array => SystemUserType::query()
                ->where($level->roleFlagColumn(), 1)
                ->when($level === DirectoryLevel::Group, fn (Builder $query): Builder => $query->where('adultLeaderRole', 1))
                ->orderBy('name')
                ->pluck('name', 'id')
                ->map(fn (string $name): string => LegacyHtmlService::decode($name))
                ->all())
            ->query(fn (Builder $query, array $data): Builder => $query->when(
                filled($data['values'] ?? []),
                fn (Builder $query): Builder => $query->whereIn('system_users_other_roles.roleID', $data['values']),
            ));
    }

    /**
     * Only built for adult leader viewers, so nothing about these columns (not even the label)
     * reaches anyone else's page.
     *
     * @return array<TextColumn>
     */
    private function contactColumns(): array
    {
        return [
            TextColumn::make('email')
                ->label('Email')
                ->state(fn (SystemUsersOtherRole $record): ?string => $this->emailFor($record))
                ->url(fn (?string $state): ?string => $this->isMailable($state) ? "mailto:{$state}" : null)
                ->placeholder('-')
                ->toggleable(),
            TextColumn::make('cell_number')
                ->label('Cell Number')
                ->state(fn (SystemUsersOtherRole $record): ?string => $this->cellNumberFor($record))
                ->url(fn (?string $state): ?string => filled($state) && $state !== self::REDACTED ? "tel:{$state}" : null)
                ->placeholder('-')
                ->toggleable(),
        ];
    }

    /**
     * The only system_users columns the directory ever loads. Contact and redaction columns are
     * added solely for adult leader viewers.
     *
     * @return array<string>
     */
    private function userColumns(bool $contactDetailsVisible): array
    {
        $columns = ['id', 'first_name', 'knownName', 'surname'];

        if ($contactDetailsVisible) {
            $columns = [...$columns, 'username', 'cellNr', 'infoRedacted'];
        }

        return $columns;
    }

    private function emailFor(SystemUsersOtherRole $record): ?string
    {
        $user = $record->user;

        if ($user->infoRedacted === 1) {
            return self::REDACTED;
        }

        return $this->isMailable($user->username) ? $user->username : null;
    }

    private function cellNumberFor(SystemUsersOtherRole $record): ?string
    {
        $user = $record->user;

        if ($user->infoRedacted === 1) {
            return self::REDACTED;
        }

        if ($this->cellNumberHiddenFor($record)) {
            return null;
        }

        return filled($user->cellNr) ? $user->cellNr : null;
    }

    private function isMailable(?string $email): bool
    {
        return filled($email) && str_contains($email, '@');
    }
}
