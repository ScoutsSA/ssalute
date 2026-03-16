<?php

namespace App\Providers\Filament;

use App\Filament\General\Pages\ChangePassword;
use App\Filament\General\Pages\Dashboard;
use App\Filament\General\Pages\ViewProfile;
use App\Http\Middleware\RedirectToValidTenant;
use App\Mail\ReportSystemIssueEmail;
use App\Models\SystemUsersOtherRole;
use App\Settings\GeneralSettings;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Notifications\Notification;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class GeneralPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('general')
            ->path('general')
            ->viteTheme('resources/css/filament/general/theme.css')
            ->favicon(asset('images/logo.png'))
            ->login()
            ->colors([
                'primary' => '#5C2D91',
            ])
            ->tenant(SystemUsersOtherRole::class)
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label('My Profile')
                    ->icon(Heroicon::UserCircle)
                    ->url(fn () => ViewProfile::getUrl(panel: 'general', tenant: Filament::getTenant())),
                'change-password' => Action::make('change-password')
                    ->label('Change Password')
                    ->icon(Heroicon::Key)
                    ->url(fn () => ChangePassword::getUrl(panel: 'general', tenant: Filament::getTenant())),
                'report-system-issue' => Action::make('report-system-issue')
                    ->label('Report System Issue')
                    ->icon(Heroicon::ExclamationTriangle)
                    ->color('danger')
                    ->visible(fn () => app(GeneralSettings::class)->system_issue_support_enabled)
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
                        $settings = app(GeneralSettings::class);
                        $userIds = $settings->system_issue_support_user_ids ?? [];

                        $to = \App\Models\SystemUser::whereIn('id', $userIds)
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
                    }),
            ])
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                fn () => Blade::render('<div class="text-center"><a href="{{ route(\'password.request\') }}" class="text-sm text-primary-600 hover:text-primary-500 dark:text-primary-400">Forgot your password?</a></div>'),
            )
            ->discoverClusters(in: app_path('Filament/General/Clusters'), for: 'App\\Filament\\General\\Clusters')
            ->discoverResources(in: app_path('Filament/General/Resources'), for: 'App\Filament\General\Resources')
            ->discoverPages(in: app_path('Filament/General/Pages'), for: 'App\Filament\General\Pages')
            ->discoverWidgets(in: app_path('Filament/General/Widgets'), for: 'App\Filament\General\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                RedirectToValidTenant::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
