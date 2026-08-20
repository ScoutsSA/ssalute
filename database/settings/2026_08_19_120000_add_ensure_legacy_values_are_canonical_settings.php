<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('data_fixes.ensure_legacy_values_are_canonical_enabled', true);
        $this->migrator->add('data_fixes.ensure_legacy_values_are_canonical_notifications', true);
    }
};
