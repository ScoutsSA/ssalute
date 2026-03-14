<?php

namespace App\Services;

class FileUrlService
{
    public function url(string $path): string
    {
        return rtrim(config('ssalute.scouts_digital_url'), '/') . '/' . ltrim($path, '/');
    }
}
