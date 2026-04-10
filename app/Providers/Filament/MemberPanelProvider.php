<?php

namespace App\Providers\Filament;

use App\Filament\Member\Pages\Dashboard;
use App\Filament\Shared\Navigation\NavigationItems;
use App\Filament\Shared\Navigation\UserMenuItems;
use App\Filament\Shared\Widgets\MissingAppointmentNotice;
use App\Filament\Shared\Widgets\MissingWarrantNotice;
use App\Http\Middleware\EnsureValidWarrant;
use App\Http\Middleware\RedirectToValidTenant;
use App\Models\SystemUsersOtherRole;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MemberPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('member')
            ->path('member')
            ->viteTheme('resources/css/filament/general/theme.css')
            ->favicon(asset('images/logo.png'))
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
                NavigationItems::myProfile('member'),
                ...NavigationItems::externalLinks(),
            ])
            ->userMenuItems(UserMenuItems::all('member'))
            ->discoverClusters(in: app_path('Filament/Member/Clusters'), for: 'App\Filament\Member\Clusters')
            ->discoverResources(in: app_path('Filament/Member/Resources'), for: 'App\Filament\Member\Resources')
            ->discoverPages(in: app_path('Filament/Member/Pages'), for: 'App\Filament\Member\Pages')
            ->discoverWidgets(in: app_path('Filament/Member/Widgets'), for: 'App\Filament\Member\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                MissingWarrantNotice::class,
                MissingAppointmentNotice::class,
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
            ->tenantMiddleware([
                EnsureValidWarrant::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
