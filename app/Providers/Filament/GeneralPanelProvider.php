<?php

namespace App\Providers\Filament;

use App\Filament\General\Pages\ChangePassword;
use App\Filament\General\Pages\Dashboard;
use App\Filament\General\Resources\Profile\ProfileResource;
use App\Http\Middleware\RedirectToValidTenant;
use App\Mail\ReportSystemIssueEmail;
use App\Models\SystemUsersOtherRole;
use App\Settings\FeatureSettings;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as FilamentDashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
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
            ->login(\App\Filament\General\Pages\Auth\Login::class)
            ->passwordReset()
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn (): View => view('filament.general.login-blurb'),
            )
            ->spa()
            ->unsavedChangesAlerts()
            ->colors([
                'primary' => '#5C2D91',
            ])
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->tenant(SystemUsersOtherRole::class)
            ->navigationGroups([
                NavigationGroup::make('External Links')
                    ->collapsed(),
            ])
            ->navigationItems([
                NavigationItem::make('My Profile')
                    ->icon(Heroicon::UserCircle)
                    ->group('My Info')
                    ->sort(1)
                    ->url(fn () => ProfileResource::getUrl('view', ['record' => auth()->id()]))
                    ->isActiveWhen(fn () => request()->routeIs('filament.general.resources.profile.*')),

                NavigationItem::make('Scouts Digital')
                    ->icon(Heroicon::GlobeAlt)
                    ->group('External Links')
                    ->sort(1)
                    ->url('https://ssa.scouts.digital', shouldOpenInNewTab: true),
                NavigationItem::make('Permit System')
                    ->icon(Heroicon::ClipboardDocumentCheck)
                    ->group('External Links')
                    ->sort(2)
                    ->url('https://permits.scouts.org.za', shouldOpenInNewTab: true),
                NavigationItem::make('Scout Wiki')
                    ->icon(Heroicon::BookOpen)
                    ->group('External Links')
                    ->sort(3)
                    ->url('https://scoutwiki.scouts.org.za/wiki/SCOUTS_South_Africa_Wiki', shouldOpenInNewTab: true),
                NavigationItem::make('National Website')
                    ->icon(Heroicon::BuildingOffice)
                    ->group('External Links')
                    ->sort(4)
                    ->url('https://www.scouts.org.za/', shouldOpenInNewTab: true),
                NavigationItem::make('Alumni')
                    ->icon(Heroicon::AcademicCap)
                    ->group('External Links')
                    ->sort(5)
                    ->url('https://www.scouts.org.za/get-involved/scouts-sa-alumni/', shouldOpenInNewTab: true),
                NavigationItem::make('General Support')
                    ->icon(Heroicon::Lifebuoy)
                    ->group('External Links')
                    ->sort(6)
                    ->url('https://support.scouts.org.za/', shouldOpenInNewTab: true),
                NavigationItem::make('Donations')
                    ->icon(Heroicon::Heart)
                    ->group('External Links')
                    ->sort(7)
                    ->url('https://www.scoutfoundation.org.za/donate/#monthly-donation-options', shouldOpenInNewTab: true),
                NavigationItem::make('Slack Group')
                    ->icon(Heroicon::ChatBubbleLeftRight)
                    ->group('External Links')
                    ->sort(8)
                    ->url('https://join.slack.com/t/scoutssa/shared_invite/zt-3ss7zpgqa-UkqirUjoLRX9jd8R0lpu~w', shouldOpenInNewTab: true),
            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label('My Profile')
                    ->icon(Heroicon::UserCircle)
                    ->url(fn () => ProfileResource::getUrl('view', ['record' => auth()->id()])),
                'change-password' => Action::make('change-password')
                    ->label('Change Password')
                    ->icon(Heroicon::Key)
                    ->url(fn () => ChangePassword::getUrl(panel: 'general', tenant: Filament::getTenant())),
                'admin-panel' => Action::make('admin-panel')
                    ->label('Backoffice Admin')
                    ->icon(Heroicon::Cog6Tooth)
                    ->url(fn () => FilamentDashboard::getUrl(panel: 'admin'))
                    ->visible(fn () => auth()->user()?->isSuperAdmin()),
                'report-system-issue' => Action::make('report-system-issue')
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
