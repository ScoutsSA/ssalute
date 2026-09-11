<?php

namespace App\Filament\Member\Clusters\Directory\Pages;

use App\Enums\DirectoryLevel;
use App\Filament\Member\Clusters\Directory\DirectoryCluster;
use App\Filament\Member\Resources\Profile\ProfileResource;
use App\Mail\Directory\ContactViaSystemEmail;
use App\Models\SystemContactMessage;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Services\LegacyHtmlService;
use App\Services\WhatsAppLinkService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

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

    private const int CONTACT_MESSAGES_PER_HOUR = 10;

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
        return 'Directory: Adult Leaders';
    }

    public function getSubheading(): string
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
            ->recordActions($contactDetailsVisible ? [
                $this->contactViaSystemAction(),
                ActionGroup::make([
                    $this->contactUrgentlyAction(),
                    $this->informationRedactedAction(),
                ]),
            ] : [])
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
        return $this->viewer()->isAdultLeader();
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
     * Lets an adult leader message any listed member through the system, with replies going to
     * them. The leader is copied in unless the member redacted their contact details, because a
     * copy would carry the member's address in its To header. Only offered to adult leader viewers, for rows with a usable
     * email address on file, and every message is recorded in system_contact_messages.
     */
    private function contactViaSystemAction(): Action
    {
        return Action::make('contact')
            ->label('Contact')
            ->icon(Heroicon::Envelope)
            ->color('primary')
            ->button()
            ->outlined()
            ->visible(fn (SystemUsersOtherRole $record): bool => $this->isMailable($record->user->username))
            ->modalHeading(fn (SystemUsersOtherRole $record): string => "Contact {$record->user->name}")
            ->modalDescription(fn (SystemUsersOtherRole $record): string => $record->user->infoRedacted === 1
                ? 'This member has redacted their contact details. Your message is sent through the system without revealing their email address or cell number, so you will not receive a copy, but any reply comes straight back to your own email address.'
                : 'Your message is sent through the system. You are copied in, and any reply comes straight back to your own email address.')
            ->modalSubmitActionLabel('Send message')
            ->schema([
                TextInput::make('subject')
                    ->label('Subject')
                    ->required()
                    ->maxLength(150)
                    ->default(fn (): string => "Message from {$this->viewer()->name} via the SCOUTS South Africa directory"),
                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->rows(10)
                    ->maxLength(5000)
                    ->default(fn (SystemUsersOtherRole $record): string => $this->prefilledMessageFor($record)),
            ])
            ->action(function (SystemUsersOtherRole $record, array $data): void {
                $this->sendContactViaSystem($record, $data['subject'], $data['message']);
            });
    }

    /**
     * The member's real contact details, for when a matter cannot wait for a reply through the
     * system. Never offered for a member who has redacted their information.
     */
    private function contactUrgentlyAction(): Action
    {
        return Action::make('contactUrgently')
            ->label('Contact urgently')
            ->icon(Heroicon::ExclamationTriangle)
            ->color('danger')
            ->visible(fn (SystemUsersOtherRole $record): bool => $record->user->infoRedacted !== 1
                && ($this->isMailable($record->user->username) || filled($record->user->cellNr)))
            ->modalHeading(fn (SystemUsersOtherRole $record): string => "Contact {$record->user->name} urgently")
            ->modalDescription('Direct contact details, for matters that cannot wait for a reply through the system.')
            ->modalWidth(Width::Medium)
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->schema([
                TextEntry::make('email')
                    ->label('Email')
                    ->state(fn (SystemUsersOtherRole $record): ?string => $this->emailFor($record))
                    ->url(fn (?string $state): ?string => $this->isMailable($state) ? "mailto:{$state}" : null)
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->placeholder('No email address on file'),
                TextEntry::make('cell_number')
                    ->label('Cell Number')
                    ->state(fn (SystemUsersOtherRole $record): ?string => $this->cellNumberFor($record))
                    ->url(fn (?string $state): ?string => filled($state) ? "tel:{$state}" : null)
                    ->copyable()
                    ->copyMessage('Cell number copied')
                    ->placeholder('No cell number on file')
                    ->afterContent(Action::make('whatsApp')
                        ->label('Open a WhatsApp chat')
                        ->icon(Heroicon::ChatBubbleOvalLeft)
                        ->color('success')
                        ->iconButton()
                        ->visible(fn (SystemUsersOtherRole $record): bool => $this->whatsAppLinkFor($record) !== null)
                        ->url(fn (SystemUsersOtherRole $record): ?string => $this->whatsAppLinkFor($record))
                        ->openUrlInNewTab()),
            ]);
    }

    /**
     * Takes the place of Contact urgently for a member who redacted their details, and points
     * the viewer at their own profile page should they want to do the same.
     */
    private function informationRedactedAction(): Action
    {
        return Action::make('informationRedacted')
            ->label('Information redacted')
            ->icon(Heroicon::EyeSlash)
            ->color('gray')
            ->visible(fn (SystemUsersOtherRole $record): bool => $record->user->infoRedacted === 1)
            ->modalHeading(fn (SystemUsersOtherRole $record): string => "{$record->user->name} has redacted their contact info")
            ->modalDescription('This member has chosen not to share their email address and cell number in the adult leader directory. You can still reach them with the Contact button, which sends your message through the system without revealing their details. If you would like to redact your own contact info in the directory, you can do so on your profile page, found in the menu at the top right of the screen.')
            ->modalIcon(Heroicon::EyeSlash)
            ->modalWidth(Width::Medium)
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->extraModalFooterActions([
                Action::make('goToProfile')
                    ->label('Go to my profile')
                    ->icon(Heroicon::UserCircle)
                    ->url(fn (): string => ProfileResource::getUrl('view', ['record' => $this->viewer()->id])),
            ]);
    }

    private function sendContactViaSystem(SystemUsersOtherRole $record, string $subject, string $message): void
    {
        $viewer = $this->viewer();

        if (! $this->isMailable($viewer->username)) {
            Notification::make()
                ->title('Your own profile has no valid email address, so replies could not reach you')
                ->danger()
                ->send();

            return;
        }

        $allowed = RateLimiter::attempt(
            "directory-contact:{$viewer->id}",
            self::CONTACT_MESSAGES_PER_HOUR,
            function () use ($viewer, $record, $subject, $message): void {
                SystemContactMessage::query()->create([
                    'sender_user_id' => $viewer->id,
                    'sender_role_attachment_id' => $this->tenant()->id,
                    'recipient_user_id' => $record->user->id,
                    'recipient_role_attachment_id' => $record->id,
                    'directory_level' => static::level(),
                    'subject' => $subject,
                    'message' => $message,
                    'sent_at' => now(),
                ]);

                Mail::to($record->user->username)
                    ->when($record->user->infoRedacted !== 1, fn ($mail) => $mail->cc($viewer->username))
                    ->send(new ContactViaSystemEmail($viewer, $record->user, $subject, $message));
            },
            decaySeconds: 3600,
        );

        if (! $allowed) {
            Notification::make()
                ->title('Too many messages sent, please try again later')
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title("Message sent to {$record->user->name}")
            ->body($record->user->infoRedacted === 1
                ? 'Any reply will go to your own email address.'
                : 'You are copied in, and any reply will go to your own email address.')
            ->success()
            ->send();
    }

    private function prefilledMessageFor(SystemUsersOtherRole $record): string
    {
        $viewer = $this->viewer();
        $tenant = $this->tenant();
        $recipientFirstName = filled($record->user->knownName) ? $record->user->knownName : $record->user->first_name;
        $roleName = LegacyHtmlService::decode($record->role->name);
        $viewerRole = LegacyHtmlService::decode($tenant->role->name);
        $viewerScope = $tenant->roleScopedLabel;

        return implode("\n", [
            "Hi {$recipientFirstName},",
            '',
            "I found you in the SCOUTS South Africa directory as {$roleName} and would like to get in touch.",
            '',
            '',
            '',
            'Kind regards,',
            $viewer->name,
            $viewerScope ? "{$viewerRole}, {$viewerScope}" : $viewerRole,
        ]);
    }

    private function viewer(): SystemUser
    {
        /** @var SystemUser $viewer */
        $viewer = auth()->user();

        return $viewer;
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
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('cell_number')
                ->label('Cell Number')
                ->state(fn (SystemUsersOtherRole $record): ?string => $this->cellNumberFor($record))
                ->url(fn (?string $state): ?string => filled($state) && $state !== self::REDACTED ? "tel:{$state}" : null)
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('whatsapp')
                ->label('WhatsApp')
                ->state(fn (SystemUsersOtherRole $record): ?string => $this->whatsAppLinkFor($record))
                ->icon(fn (?string $state): ?Heroicon => $state ? Heroicon::ChatBubbleOvalLeft : null)
                ->color('success')
                ->tooltip('Open a WhatsApp chat')
                ->url(fn (?string $state): ?string => $state)
                ->openUrlInNewTab()
                ->toggleable(isToggledHiddenByDefault: true),
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

    private function whatsAppLinkFor(SystemUsersOtherRole $record): ?string
    {
        $cellNumber = $this->cellNumberFor($record);

        if ($cellNumber === null || $cellNumber === self::REDACTED) {
            return null;
        }

        return WhatsAppLinkService::for($cellNumber);
    }

    private function isMailable(?string $email): bool
    {
        return filled($email) && str_contains($email, '@');
    }
}
