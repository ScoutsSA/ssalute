<?php

namespace App\Filament\General\Pages;

use App\Mail\Profile\EndorsementRequestEmail;
use App\Models\MembershipCertificate as MembershipCertificateModel;
use App\Models\SystemUsersOtherRole;
use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Js;
use UnitEnum;

class MembershipCertificate extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::DocumentCheck;

    protected static ?string $navigationLabel = 'Membership Certificate';

    protected static ?string $title = 'Membership Certificate';

    protected static string|UnitEnum|null $navigationGroup = 'My Info';

    protected static ?int $navigationSort = 3;

    /** @var array<string> */
    public array $selectedFields = ['name', 'ssa_id', 'roles', 'email', 'phone', 'start_date'];

    public bool $includePhoto = true;

    protected string $view = 'filament.general.pages.membership-certificate';

    public static function canAccess(): bool
    {
        if (! resolve(FeatureSettings::class)->users_can_generate_membership_certificate) {
            return false;
        }

        return static::userIsMember();
    }

    /**
     * Available fields that can be shown on the certificate.
     *
     * @return array<string, string>
     */
    public static function availableFields(): array
    {
        return [
            'name' => 'Full Name',
            'ssa_id' => 'SSA Membership ID',
            'email' => 'Email Address',
            'phone' => 'Phone Number',
            'roles' => 'Active Roles',
            'start_date' => 'Membership Start Date',
            'date_invested' => 'Date Invested',
        ];
    }

    private static function userIsMember(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        $activeAttachments = $user->activeRoleAttachments()->with('role')->get();

        return MembershipCertificateModel::userHasEligibleRoles($activeAttachments);
    }

    public function mount(): void
    {
        $certificate = auth()->user()->membershipCertificate;

        if ($certificate) {
            $visibleFields = $certificate->visible_fields;
            $this->includePhoto = in_array('photo', $visibleFields);
            $this->selectedFields = array_values(array_diff($visibleFields, ['photo']));
        }
    }

    public function getExistingCertificate(): ?MembershipCertificateModel
    {
        return auth()->user()->membershipCertificate;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Important Notice')
                    ->icon(Heroicon::ExclamationTriangle)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('notice')
                            ->hiddenLabel()
                            ->state('This Membership Certificate is purely a confirmation of your active membership with Scouts South Africa. It is NOT a nomination, letter of endorsement, or letter of introduction. It simply verifies that you are a registered and active member.')
                            ->color('warning'),
                    ]),

                Section::make('Select Information to Display')
                    ->description('Choose which personal information should be visible on your shareable membership certificate.')
                    ->collapsible()
                    ->schema([
                        CheckboxList::make('selectedFields')
                            ->label('Visible Information')
                            ->options(static::availableFields())
                            ->descriptions([
                                'name' => 'Your full name as registered',
                                'ssa_id' => 'Your unique SSA membership number',
                                'email' => 'Your registered email address',
                                'phone' => 'Your cell phone number',
                                'roles' => 'All your current active roles and their areas',
                                'start_date' => 'The date your membership started',
                                'date_invested' => 'The date you were invested',
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                        Toggle::make('includePhoto')
                            ->label('Include profile photo')
                            ->helperText('Display your profile photo on the certificate.'),
                    ])
                    ->footer([
                        Action::make('saveCertificate')
                            ->label($this->getExistingCertificate() ? 'Update Certificate' : 'Generate Certificate')
                            ->icon(Heroicon::DocumentArrowDown)
                            ->color('primary')
                            ->action(function (): void {
                                $this->saveCertificate();
                            }),
                        Action::make('removeCertificate')
                            ->label('Remove Certificate')
                            ->icon(Heroicon::Trash)
                            ->color('danger')
                            ->requiresConfirmation()
                            ->modalHeading('Remove Certificate')
                            ->modalDescription('Are you sure you want to remove your membership certificate? The shared link will stop working immediately.')
                            ->visible(fn () => $this->getExistingCertificate() !== null)
                            ->action(function (): void {
                                $this->removeCertificate();
                            }),
                    ]),
            ]);
    }

    public function saveCertificate(): void
    {
        $user = auth()->user();

        $visibleFields = $this->selectedFields;
        if ($this->includePhoto) {
            $visibleFields[] = 'photo';
        }

        if (empty($visibleFields)) {
            Notification::make()
                ->title('Please select at least one field to display.')
                ->danger()
                ->send();

            return;
        }

        $certificate = MembershipCertificateModel::updateOrCreate(
            ['user_id' => $user->id],
            ['visible_fields' => $visibleFields],
        );

        $url = route('membership-certificate.show', $certificate->uuid);

        auth()->user()->unsetRelation('membershipCertificate');

        Notification::make()
            ->title('Certificate saved successfully!')
            ->success()
            ->persistent()
            ->actions([
                Action::make('viewCertificateNotification')
                    ->label('View Certificate')
                    ->button()
                    ->url($url, shouldOpenInNewTab: true),
                Action::make('copyCertificateLink')
                    ->label('Copy Link')
                    ->color('gray')
                    ->alpineClickHandler('window.navigator.clipboard.writeText(' . Js::from($url) . ").then(() => { let btn = \$el; let original = btn.textContent; btn.textContent = 'Copied!'; setTimeout(() => btn.textContent = original, 2000) })"),
            ])
            ->send();

        $this->redirect(static::getUrl(), navigate: true);
    }

    public function removeCertificate(): void
    {
        $certificate = $this->getExistingCertificate();

        if (! $certificate) {
            return;
        }

        $certificate->delete();
        auth()->user()->unsetRelation('membershipCertificate');

        Notification::make()
            ->title('Certificate removed')
            ->body('Your membership certificate has been removed and the shared link will no longer work.')
            ->success()
            ->send();

        $this->redirect(static::getUrl(), navigate: true);
    }

    protected function getHeaderActions(): array
    {
        $certificate = $this->getExistingCertificate();

        return [
            Action::make('viewCertificate')
                ->label('View Certificate')
                ->icon(Heroicon::ArrowTopRightOnSquare)
                ->color('success')
                ->url(fn () => $certificate ? route('membership-certificate.show', $certificate->uuid) : null)
                ->openUrlInNewTab()
                ->visible(fn () => $certificate !== null),

            Action::make('requestEndorsement')
                ->label('Request Endorsement')
                ->icon(Heroicon::EnvelopeOpen)
                ->color('warning')
                ->visible(fn () => resolve(FeatureSettings::class)->users_can_request_endorsement)
                ->modalHeading('Request Endorsement')
                ->modalDescription('Submit a request for endorsement to the International Committee Representatives. This is separate from your membership certificate.')
                ->schema([
                    TextInput::make('subject')
                        ->label('Subject')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('e.g. Endorsement for international event attendance'),
                    Textarea::make('description')
                        ->label('Description')
                        ->required()
                        ->rows(5)
                        ->placeholder('Describe the purpose of the endorsement and any relevant details...'),
                ])
                ->action(function (array $data): void {
                    $this->sendEndorsementRequest($data['subject'], $data['description']);
                }),
        ];
    }

    private function sendEndorsementRequest(string $subject, string $description): void
    {
        $requester = auth()->user();
        $settings = resolve(FeatureSettings::class);
        $roleIds = $settings->international_committee_representative_role_ids ?? [];

        if (empty($roleIds)) {
            Notification::make()
                ->title('No International Committee Representatives configured')
                ->body('Please contact your administrator to configure the International Committee Representative roles in settings.')
                ->danger()
                ->send();

            return;
        }

        $recipients = SystemUsersOtherRole::query()
            ->whereIn('roleID', $roleIds)
            ->where('active', 1)
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->unique('id')
            ->pluck('username')
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->values()
            ->all();

        if (empty($recipients)) {
            Notification::make()
                ->title('No valid recipients found')
                ->body('No active users with International Committee Representative roles have valid email addresses.')
                ->danger()
                ->send();

            return;
        }

        $mail = Mail::to($recipients);

        if (filter_var($requester->username, FILTER_VALIDATE_EMAIL)) {
            $mail->cc($requester->username);
        }

        $mail->send(new EndorsementRequestEmail($requester, endorsementSubject: $subject, description: $description));

        Notification::make()
            ->title('Endorsement request sent successfully')
            ->body('Your request has been sent to the International Committee Representatives. You have been CC\'d on the email.')
            ->success()
            ->send();
    }
}
