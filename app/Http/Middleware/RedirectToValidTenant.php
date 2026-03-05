<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Http\Request;

class RedirectToValidTenant
{
    public function handle(Request $request, Closure $next): mixed
    {
        $panel = Filament::getCurrentOrDefaultPanel();

        if (! $panel->hasTenancy()) {
            return $next($request);
        }

        if (! $request->route()?->hasParameter('tenant')) {
            return $next($request);
        }

        $user = $panel->auth()->user();

        // Not authenticated yet — let the auth middleware handle it
        if (! $user instanceof HasTenants) {
            return $next($request);
        }

        $tenantKey = $request->route()->parameter('tenant');
        $tenant = $panel->getTenant($tenantKey);

        // Tenant doesn't exist at all, or the user can already access it — pass through
        if (! $tenant || $user->canAccessTenant($tenant)) {
            return $next($request);
        }

        // User can't access this tenant — try to find one they can
        $fallback = $user instanceof HasDefaultTenant
            ? $user->getDefaultTenant($panel)
            : null;

        $fallback ??= $user->getTenants($panel)->first();

        // No valid tenants at all — let IdentifyTenant produce the 404
        if (! $fallback) {
            return $next($request);
        }

        // Redirect to the same named route but with the user's own tenant
        return redirect()->route(
            $request->route()->getName(),
            array_merge($request->route()->parameters(), ['tenant' => $fallback->getRouteKey()])
        );
    }
}
