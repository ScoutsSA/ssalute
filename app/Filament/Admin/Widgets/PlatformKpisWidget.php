<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Clusters\AdminReports\Pages\MostActiveUsers;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\WarrantResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\AmsWarrantInfo;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Number;

/**
 * The platform KPI tiles, following the legacy admin dashboard's definitions.
 * The counts scan large legacy tables, so they are cached for ten minutes; the
 * recently active numbers come from system_users.lastLoginDate, which both
 * legacy and the Ssalute login listener maintain.
 */
class PlatformKpisWidget extends Widget
{
    protected static ?int $sort = 0;

    public const string CACHE_KEY = 'backoffice.dashboard.kpis';

    public const int CACHE_SECONDS = 600;

    protected string $view = 'filament.admin.widgets.overview-card';

    protected int|string|array $columnSpan = ['lg' => 4];

    /** @return array<string, mixed> */
    protected function getViewData(): array
    {
        $kpis = Cache::remember(self::CACHE_KEY, self::CACHE_SECONDS, fn (): array => $this->computeKpis());

        return [
            'heading' => 'Platform KPIs',
            'subheading' => 'Legacy dashboard definitions, refreshed every ten minutes',
            'icon' => 'heroicon-o-chart-bar',
            'tileColumns' => 2,
            'stats' => [
                [
                    'label' => 'Invested Youth',
                    'value' => Number::format($kpis['invested_youth']),
                    'description' => 'Active youth members with an investiture date',
                    'icon' => 'heroicon-m-academic-cap',
                    'color' => 'primary',
                ],
                [
                    'label' => 'Invested Adults',
                    'value' => Number::format($kpis['invested_adults']),
                    'description' => 'Active warranted adult leader roles',
                    'icon' => 'heroicon-m-identification',
                    'color' => 'primary',
                ],
                [
                    'label' => 'Total Invested',
                    'value' => Number::format($kpis['invested_youth'] + $kpis['invested_adults']),
                    'description' => 'Invested youth and adults combined',
                    'icon' => 'heroicon-m-user-group',
                    'color' => 'gray',
                ],
                [
                    'label' => 'Parents & Helpers',
                    'value' => Number::format($kpis['parents_and_helpers']),
                    'description' => 'Non-warranted adult helpers and parents',
                    'icon' => 'heroicon-m-hand-raised',
                    'color' => 'primary',
                ],
                [
                    'label' => 'Total Administered',
                    'value' => Number::format($kpis['invested_youth'] + $kpis['invested_adults'] + $kpis['parents_and_helpers']),
                    'description' => 'Everyone the platform administers',
                    'icon' => 'heroicon-m-users',
                    'color' => 'gray',
                    'url' => UserResource::getUrl(panel: 'admin'),
                ],
                [
                    'label' => 'Active Warrants',
                    'value' => Number::format($kpis['active_warrants']),
                    'description' => 'Active and not yet expired',
                    'icon' => 'heroicon-m-shield-check',
                    'color' => 'success',
                    'url' => WarrantResource::getUrl(panel: 'admin'),
                ],
                [
                    'label' => 'Recently Active',
                    'value' => Number::format($kpis['active_last_hour']),
                    'description' => "Last hour, {$kpis['active_last_day']} in the last 24 hours",
                    'icon' => 'heroicon-m-bolt',
                    'color' => 'warning',
                    'url' => MostActiveUsers::getUrl(panel: 'admin'),
                ],
            ],
        ];
    }

    /** @return array<string, int> */
    private function computeKpis(): array
    {
        $youthTypeIds = SystemUserType::query()
            ->whereIn('name', ['Meerkat', 'Cub', 'Scout', 'Rover'])
            ->pluck('id');

        $activePrimaryRoles = fn (): Builder => SystemUsersOtherRole::query()
            ->where('active', 1)
            ->where('defaultRole', 1)
            ->whereHas('user', fn (Builder $query) => $query->where('active', 1));

        $investedYouth = $activePrimaryRoles()
            ->whereIn('roleID', $youthTypeIds)
            ->whereHas('user', fn (Builder $query) => $query->whereNotNull('dateInvested'))
            ->count();

        $investedAdults = $activePrimaryRoles()
            ->whereHas('role', fn (Builder $query) => $query
                ->where('adultLeaderRole', 1)
                ->where('warrantedRole', 1))
            ->count();

        $parentsAndHelpers = $activePrimaryRoles()
            ->where(fn (Builder $query) => $query
                ->whereHas('role', fn (Builder $role) => $role
                    ->where('adultLeaderRole', 1)
                    ->where('warrantedRole', 0))
                ->orWhereHas('role', fn (Builder $role) => $role->where('name', 'Parent')))
            ->count();

        return [
            'invested_youth' => $investedYouth,
            'invested_adults' => $investedAdults,
            'parents_and_helpers' => $parentsAndHelpers,
            'active_warrants' => AmsWarrantInfo::query()
                ->where('active', 1)
                ->whereDate('expireDate', '>=', today())
                ->count(),
            'active_last_hour' => SystemUser::query()->where('lastLoginDate', '>=', now()->subHour())->count(),
            'active_last_day' => SystemUser::query()->where('lastLoginDate', '>=', now()->subDay())->count(),
        ];
    }
}
