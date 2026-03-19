<?php

namespace App\Filament\General\Resources\Profile\Pages;

use App\Filament\General\Resources\Profile\ProfileResource;
use App\Models\MembershipCertificate as MembershipCertificateModel;
use App\Settings\FeatureSettings;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Js;

class MembershipCertificate extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProfileResource::class;

    protected static ?string $title = 'Membership Certificate';




    /** Fields that are always included on the certificate. */
    public const REQUIRED_FIELDS = ['name', 'ssa_id', 'roles'];

    /** @var array<string> */
    public array $requiredFields = ['name', 'ssa_id', 'roles'];

    /** @var array<string> */
    public array $selectedFields = ['email', 'phone', 'age', 'date_invested'];

    public bool $includePhoto = true;

    protected string $view = 'filament.general.pages.membership-certificate';

    public static function canAccess(array $parameters = []): bool
    {
        if (! resolve(FeatureSettings::class)->users_can_generate_membership_certificate) {
            return false;
        }

        return static::userIsMember();
    }

    /**
     * Optional fields that can be shown on the certificate.
     *
     * @return array<string, string>
     */
    public static function optionalFields(): array
    {
        return [
            'email' => 'Email Address',
            'phone' => 'Phone Number',
            'age' => 'Age',
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

    public function getBreadcrumbs(): array
    {
        return [
            ProfileResource::getUrl('view', ['record' => auth()->id()]) => 'My Profile',
            '' => 'Membership Certificate',
        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $certificate = auth()->user()->membershipCertificate;

        if ($certificate) {
            $visibleFields = $certificate->visible_fields;
            $this->includePhoto = in_array('photo', $visibleFields);
            $this->selectedFields = array_values(array_diff($visibleFields, ['photo', ...self::REQUIRED_FIELDS]));
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
                        CheckboxList::make('requiredFields')
                            ->label('Always Included')
                            ->options([
                                'name' => 'Full Name',
                                'ssa_id' => 'SSA Membership ID',
                                'roles' => 'Active Roles',
                            ])
                            ->disableOptionWhen(fn (): bool => true)
                            ->columns(3)
                            ->columnSpanFull(),
                        Section::make('Optional Information')
                            ->schema([
                                Toggle::make('includePhoto')
                                    ->label('Include profile photo')
                                    ->helperText('Display your profile photo on the certificate.')
                                    ->inline()
                                    ->columnSpan(1),
                                CheckboxList::make('selectedFields')
                                    ->label('Other Fields')
                                    ->options(static::optionalFields())
                                    ->descriptions([
                                        'email' => 'Your registered email address',
                                        'phone' => 'Your cell phone number',
                                        'age' => 'Your current age (calculated from date of birth)',
                                        'date_invested' => 'The date you were invested',
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ])

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

        $visibleFields = array_values(array_unique([...self::REQUIRED_FIELDS, ...$this->selectedFields]));
        if ($this->includePhoto) {
            $visibleFields[] = 'photo';
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

        $this->redirect(static::getUrl(['record' => $this->getRecord()]), navigate: true);
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

        $this->redirect(static::getUrl(['record' => $this->getRecord()]), navigate: true);
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

        ];
    }
}
