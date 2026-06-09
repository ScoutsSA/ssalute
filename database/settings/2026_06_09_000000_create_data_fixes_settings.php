<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('data_fixes.ensure_each_user_has_only_one_primary_role_enabled', true);
        $this->migrator->add('data_fixes.ensure_each_user_has_only_one_primary_role_notifications', true);
        $this->migrator->add('data_fixes.notifications_enabled', true);
        $this->migrator->add('data_fixes.slack_webhook_url', null);
    }
};
