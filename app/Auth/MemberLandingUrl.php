<?php

namespace App\Auth;

use App\Models\SystemUser;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;

/**
 * Where a freshly logged in member goes: their default tenant's dashboard in
 * the member panel, or the holding zone when they have no tenant yet.
 */
class MemberLandingUrl
{
    public static function for(SystemUser $user): string
    {
        $tenant = $user->getDefaultTenant(Filament::getPanel('member'));

        if (! $tenant) {
            return Filament::getPanel('holding-zone')->getUrl();
        }

        return Dashboard::getUrl(panel: 'member', tenant: $tenant);
    }
}
