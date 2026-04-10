<?php

namespace App\Filament\Shared\Navigation;

use App\Filament\Member\Pages\ChangePassword;
use App\Filament\Member\Resources\Profile\ProfileResource;
use App\Mail\ReportSystemIssueEmail;
use App\Models\SystemUser;
use App\Settings\FeatureSettings;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

class UserMenuItems
{
    /**
     * @return array<string, Action>
     */
    public static function all(string $panel): array
    {
        return [
            'profile' => self::profile($panel),
            'change-password' => self::changePassword($panel),
            'admin-panel' => self::adminPanel(),
            'report-system-issue' => self::reportSystemIssue(),
        ];
    }

    public static function profile(string $panel): Action
    {
        return Action::make('profile')
            ->label('My Profile')
            ->icon(Heroicon::UserCircle)
            ->url(fn () => ProfileResource::getUrl('view', ['record' => auth()->id()], panel: $panel));
    }

    public static function changePassword(string $panel): Action
    {
        return Action::make('change-password')
            ->label('Change Password')
            ->icon(Heroicon::Key)
            ->url(fn () => ChangePassword::getUrl(
                panel: $panel,
                tenant: Filament::getPanel($panel)->hasTenancy() ? Filament::getTenant() : null,
            ));
    }

    public static function adminPanel(): Action
    {
        return Action::make('admin-panel')
            ->label('Backoffice Admin')
            ->icon(Heroicon::Cog6Tooth)
            ->url(fn () => Dashboard::getUrl(panel: 'admin'))
            ->visible(fn () => auth()->user()?->isSuperAdmin());
    }

    public static function reportSystemIssue(): Action
    {
        return Action::make('report-system-issue')
            ->label('Report System Issue')
            ->icon(Heroicon::ExclamationTriangle)
            ->color('danger')
            ->visible(fn () => app(FeatureSettings::class)->system_issue_support_enabled)
            ->modalHeading('Report a System Issue')
            ->modalDescription('Describe the system issue you are experiencing. This will be sent to the Ssalute support team.')
            ->schema([
                Textarea::make('description')
                    ->label('Describe the issue')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ])
            ->action(function (array $data): void {
                $reporter = auth()->user();
                $settings = app(FeatureSettings::class);
                $userIds = $settings->system_issue_support_user_ids ?? [];

                $to = SystemUser::whereIn('id', $userIds)
                    ->pluck('username')
                    ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
                    ->unique()
                    ->values()
                    ->all();

                if (empty($to)) {
                    Notification::make()
                        ->title('No system support recipients configured')
                        ->danger()
                        ->send();

                    return;
                }

                Mail::to($to)
                    ->cc($reporter->username)
                    ->send(new ReportSystemIssueEmail($reporter, $data['description']));

                Notification::make()
                    ->title('System issue reported successfully')
                    ->success()
                    ->send();
            });
    }
}
