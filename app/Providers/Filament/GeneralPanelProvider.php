<?php

namespace App\Providers\Filament;

use App\Filament\General\Pages\Dashboard;
use App\Filament\General\Pages\ViewProfile;
use App\Http\Middleware\RedirectToValidTenant;
use App\Models\SystemUsersOtherRole;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class GeneralPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('general')
            ->path('general')
            ->favicon(asset('images/logo.png'))
            ->login()
            ->colors([
                'primary' => '#5C2D91',
            ])
            ->tenant(SystemUsersOtherRole::class)
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('My Profile')
                    ->icon(Heroicon::UserCircle)
                    ->url(fn () => ViewProfile::getUrl(panel: 'general', tenant: Filament::getTenant())),
            ])
            ->discoverResources(in: app_path('Filament/General/Resources'), for: 'App\Filament\General\Resources')
            ->discoverPages(in: app_path('Filament/General/Pages'), for: 'App\Filament\General\Pages')
            ->discoverWidgets(in: app_path('Filament/General/Widgets'), for: 'App\Filament\General\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
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
