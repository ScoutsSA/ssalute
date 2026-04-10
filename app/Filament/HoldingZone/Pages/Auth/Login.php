<?php

namespace App\Filament\HoldingZone\Pages\Auth;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    public function getHeading(): string|Htmlable|null
    {
        return 'Scouts South Africa';
    }

    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        if ($response === null) {
            return null;
        }

        $user = Filament::auth()->user();
        $panel = Filament::getPanel('member');
        $tenant = $user?->getDefaultTenant($panel);

        if ($tenant) {
            $defaultUrl = Dashboard::getUrl(panel: 'member', tenant: $tenant);
            $intended = session()->pull('url.intended', $defaultUrl);
            $this->redirect($intended);

            return null;
        }

        return $response;
    }
}
