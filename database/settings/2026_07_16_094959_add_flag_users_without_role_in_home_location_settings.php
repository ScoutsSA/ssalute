<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('data_fixes.flag_users_without_role_in_home_location_enabled', true);
        $this->migrator->add('data_fixes.flag_users_without_role_in_home_location_notifications', true);
    }
};
