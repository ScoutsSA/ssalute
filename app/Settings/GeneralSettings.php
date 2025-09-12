<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public ?array $super_user_admin_list = [];

    public static function group(): string
    {
        return 'general';
    }
}
