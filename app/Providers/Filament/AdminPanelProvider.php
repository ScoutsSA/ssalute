<?php

namespace App\Providers\Filament;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('backoffice')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->default()
            ->favicon(asset('images/logo.png'))
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => '#5C2D91',
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverClusters(in: app_path('Filament/Admin/Clusters'), for: 'App\Filament\Admin\Clusters')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Users')
                    ->icon(Heroicon::User),
                NavigationGroup::make()
                    ->label('System')
                    ->icon(Heroicon::Lifebuoy),
            ])
            ->renderHook(
                PanelsRenderHook::PAGE_START,
                fn () => request()->is('backoffice/group-operations*', 'backoffice/ams*', 'backoffice/advancements*', 'backoffice/area*')
                    ? Blade::render('@include("filament.admin.partials.beta-banner")')
                    : '',
            )
            ->userMenuItems([
                'member-panel' => Action::make('member-panel')
                    ->label('Member Panel')
                    ->icon(Heroicon::ArrowLeftStartOnRectangle)
                    ->url(function () {
                        $user = auth()->user();
                        $tenant = $user?->getDefaultTenant(Filament::getPanel('member'));

                        return $tenant ? Dashboard::getUrl(panel: 'member', tenant: $tenant) : '/member';
                    }),
            ])
            ->navigationItems([
                NavigationItem::make('Horizon')
                    ->url('/horizon', shouldOpenInNewTab: true)
                    ->sort(3)
                    ->icon(Heroicon::QueueList)
                    ->group('System'),
                NavigationItem::make('Pulse')
                    ->url('/pulse', shouldOpenInNewTab: true)
                    ->sort(4)
                    ->icon(Heroicon::Heart)
                    ->group('System'),
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
