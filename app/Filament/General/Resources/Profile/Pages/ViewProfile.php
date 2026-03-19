<?php

namespace App\Filament\General\Resources\Profile\Pages;

use App\Filament\General\Resources\Profile\ProfileResource;
use App\Mail\Profile\ReportIssueEmail;
use App\Services\NextInLineService;
use App\Settings\FeatureSettings;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Js;

class ViewProfile extends ViewRecord
{
    protected static string $resource = ProfileResource::class;

    protected static ?string $title = 'My Profile';

    private static function sendToNationalToggle(): ToggleButtons
    {
        return ToggleButtons::make('send_to_national')
            ->label('Send to')
            ->options(function () {
                $nextInLine = app(NextInLineService::class)->resolve(Filament::getTenant());
                $name = $nextInLine ? trim("{$nextInLine->first_name} {$nextInLine->surname}") : null;
                $label = $name ? 'Next in Line Scouter - ' . (mb_strlen($name) > 15 ? mb_substr($name, 0, 15) . '...' : $name) : 'Next in Line Scouter';

                return [
                    false => $label,
                    true => 'National Adult Support Team',
                ];
            })
            ->icons([
                false => Heroicon::UserGroup,
                true => Heroicon::BuildingOffice2,
            ])
            ->colors([
                false => 'primary',
                true => 'danger',
            ])
            ->default(false)
            ->helperText('Please only escalate to the National Adult Support Team if your next in line scouter has been unable to help.')
            ->columnSpanFull();
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function isReadOnly(): bool
    {
        return false;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Profile')
                ->icon(Heroicon::PencilSquare)
                ->alpineClickHandler(
                    'const params = new URLSearchParams(window.location.search);' .
                    'let url = ' . Js::from(ProfileResource::getUrl('edit', ['record' => $this->getRecord()])) . ';' .
                    'if (params.has(\'tab\')) url += \'?tab=\' + encodeURIComponent(params.get(\'tab\'));' .
                    'window.location.href = url;'
                )
                ->visible(fn () => resolve(FeatureSettings::class)->users_can_edit_profiles),

            ActionGroup::make([
                Action::make('reportIssue')
                    ->label('Report Issue')
                    ->icon(Heroicon::Flag)
                    ->color('danger')
                    ->visible(fn () => resolve(FeatureSettings::class)->users_can_report_issues)
                    ->modalHeading('Report an Issue')
                    ->modalDescription('Describe the issue you are experiencing. It will be sent to your next in line scouter, or to the national adult support team.')
                    ->schema([
                        Textarea::make('description')
                            ->label('Describe the issue')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        self::sendToNationalToggle(),
                    ])
                    ->action(function (array $data): void {
                        $this->sendReportIssueEmail($data['description'], $data['send_to_national'], 'Issue reported successfully');
                    }),
                Action::make('membershipCertificate')
                    ->label('Membership Certificate')
                    ->icon(Heroicon::DocumentCheck)
                    ->url(fn () => ProfileResource::getUrl('membership-certificate', ['record' => $this->getRecord()])),
            ])
                ->label('')
                ->icon(Heroicon::EllipsisVertical)
                ->color('gray')
                ->button()
                ->visible(),
        ];
    }

    private function sendReportIssueEmail(string $description, bool $sendToNational, string $successMessage): void
    {
        $reporter = auth()->user();
        $tenant = Filament::getTenant();
        $service = app(NextInLineService::class);

        if ($sendToNational) {
            $to = $service->resolveNationalSupportEmails();
            $sentToNational = true;
        } else {
            $scouters = $service->resolveAll($tenant);
            $to = $scouters->isEmpty()
                ? $service->resolveNationalSupportEmails()
                : $scouters->map(fn ($u) => $u->username)->filter()->all();
            $sentToNational = $scouters->isEmpty();
        }

        $to = array_filter($to, fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));

        if (empty($to)) {
            Notification::make()
                ->title('No valid email recipients found')
                ->danger()
                ->send();

            return;
        }

        Mail::to($to)
            ->cc($reporter->username)
            ->send(new ReportIssueEmail($reporter, $description, $sentToNational));

        Notification::make()
            ->title($successMessage)
            ->success()
            ->send();
    }
}
