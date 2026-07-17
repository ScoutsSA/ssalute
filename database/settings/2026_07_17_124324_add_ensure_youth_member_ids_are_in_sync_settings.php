<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('data_fixes.ensure_youth_member_ids_are_in_sync_enabled', false);
        $this->migrator->add('data_fixes.ensure_youth_member_ids_are_in_sync_notifications', true);
    }
};
