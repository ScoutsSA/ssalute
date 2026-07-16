<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class DataFixesSettings extends Settings
{
    public bool $ensure_each_user_has_only_one_primary_role_enabled = true;

    public bool $ensure_each_user_has_only_one_primary_role_notifications = true;

    public bool $flag_users_without_role_in_home_location_enabled = true;

    public bool $flag_users_without_role_in_home_location_notifications = true;

    public bool $notifications_enabled = true;

    public ?string $slack_webhook_url = null;

    public static function group(): string
    {
        return 'data_fixes';
    }
}
