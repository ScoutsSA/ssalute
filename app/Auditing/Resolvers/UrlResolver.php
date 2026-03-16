<?php

namespace App\Auditing\Resolvers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Resolver;

class UrlResolver implements Resolver
{
    public static function resolve(Auditable $auditable): string
    {
        if (! empty($auditable->preloadedResolverData['url'] ?? null)) {
            return $auditable->preloadedResolverData['url'] ?? '';
        }

        if (App::runningInConsole()) {
            return 'console';
        }

        $url = Request::fullUrl();

        // Livewire actions go through /livewire/update or /livewire-{hash}/update
        if (preg_match('#/livewire(-[a-f0-9]+)?/update#', $url)) {
            return Request::header('Referer', $url);
        }

        return $url;
    }
}
