<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FormSettings extends Settings
{
    public ?array $aam_national_support_emails = null;
    public bool $aam_enabled = false;

    public static function group(): string
    {
        return 'form';
    }
}
