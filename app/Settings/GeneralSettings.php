<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public ?array $super_user_admin_list = [];

    public ?array $national_support_emails = [];

    public ?int $next_in_line_role_group = null;
    public ?int $next_in_line_role_district = null;
    public ?int $next_in_line_role_regional = null;
    public ?int $next_in_line_role_national = null;

    public static function group(): string
    {
        return 'general';
    }
}
