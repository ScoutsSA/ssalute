<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUrlService
{
    public function url(string $path): string
    {
        return Storage::disk('legacy')->temporaryUrl(
            ltrim($path, '/'),
            now()->addMinutes(30),
        );
    }
}
