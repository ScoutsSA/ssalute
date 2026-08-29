<?php

namespace App\Filament\HoldingZone\Pages\Auth;

use App\Auth\MemberLandingUrl;
use App\Models\SystemUser;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
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

        if (! $user instanceof SystemUser) {
            return $response;
        }

        $this->redirect(session()->pull('url.intended', MemberLandingUrl::for($user)));

        return null;
    }
}
