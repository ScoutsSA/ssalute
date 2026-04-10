<?php

namespace App\Providers\Filament;

use App\Filament\HoldingZone\Pages\Auth\Login;
use App\Filament\HoldingZone\Pages\Dashboard;
use App\Filament\Member\Pages\ChangePassword;
use App\Filament\Member\Resources\Profile\ProfileResource;
use App\Filament\Shared\Navigation\NavigationItems;
use App\Filament\Shared\Navigation\UserMenuItems;
use App\Filament\Shared\Widgets\MissingAppointmentNotice;
use App\Filament\Shared\Widgets\MissingWarrantNotice;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class HoldingZonePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('holding-zone')
            ->path('holding-zone')
            ->login(Login::class)
            ->passwordReset()
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn (): View => view('filament.member.login-blurb'),
            )
            ->spa()
            ->viteTheme('resources/css/filament/general/theme.css')
            ->favicon(asset('images/logo.png'))
            ->colors([
                'primary' => '#5C2D91',
            ])
            ->navigationGroups([
                NavigationGroup::make('External Links')
                    ->collapsed(),
            ])
            ->navigationItems([
                NavigationItems::myProfile('holding-zone'),
                ...NavigationItems::externalLinks(),
            ])
            ->userMenuItems(UserMenuItems::all('holding-zone'))
            ->resources([
                ProfileResource::class,
            ])
            ->discoverResources(in: app_path('Filament/HoldingZone/Resources'), for: 'App\Filament\HoldingZone\Resources')
            ->discoverPages(in: app_path('Filament/HoldingZone/Pages'), for: 'App\Filament\HoldingZone\Pages')
            ->discoverWidgets(in: app_path('Filament/HoldingZone/Widgets'), for: 'App\Filament\HoldingZone\Widgets')
            ->widgets([
                MissingWarrantNotice::class,
                MissingAppointmentNotice::class,
            ])
            ->pages([
                Dashboard::class,
                ChangePassword::class,
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
