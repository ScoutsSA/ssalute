<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AmsWarrantInfo;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Number;

/**
 * The platform KPI tiles, following the legacy admin dashboard's definitions.
 * The counts scan large legacy tables, so they are cached for ten minutes; the
 * recently active numbers come from system_users.lastLoginDate, which both
 * legacy and the Ssalute login listener maintain.
 */
class PlatformKpisWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    public const string CACHE_KEY = 'backoffice.dashboard.kpis';

    public const int CACHE_SECONDS = 600;

    protected ?string $heading = 'Platform KPIs';

    protected function getStats(): array
    {
        $kpis = Cache::remember(self::CACHE_KEY, self::CACHE_SECONDS, fn (): array => $this->computeKpis());

        return [
            Stat::make('Invested Youth', Number::format($kpis['invested_youth']))
                ->description('Active youth members with an investiture date'),
            Stat::make('Invested Adults', Number::format($kpis['invested_adults']))
                ->description('Active warranted adult leader roles'),
            Stat::make('Total Invested', Number::format($kpis['invested_youth'] + $kpis['invested_adults'])),
            Stat::make('Parents & Helpers', Number::format($kpis['parents_and_helpers']))
                ->description('Non-warranted adult helpers and parents'),
            Stat::make('Total Administered', Number::format($kpis['invested_youth'] + $kpis['invested_adults'] + $kpis['parents_and_helpers'])),
            Stat::make('Active Warrants', Number::format($kpis['active_warrants']))
                ->description('Active and not yet expired'),
            Stat::make('Recently Active', Number::format($kpis['active_last_hour']))
                ->description("Last hour, {$kpis['active_last_day']} in the last 24 hours"),
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
