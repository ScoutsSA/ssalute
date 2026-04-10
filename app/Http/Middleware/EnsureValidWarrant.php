<?php

namespace App\Http\Middleware;

use App\Models\SystemUsersOtherRole;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidWarrant
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = Filament::getTenant();

        if (! $tenant instanceof SystemUsersOtherRole) {
            return $next($request);
        }

        if (! $tenant->hasValidWarrantOrAppointment()) {
            return redirect('/holding-zone');
        }

        return $next($request);
    }
}
