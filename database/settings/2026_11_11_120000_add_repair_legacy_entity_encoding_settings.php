<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('data_fixes.repair_legacy_entity_encoding_enabled', true);
        $this->migrator->add('data_fixes.repair_legacy_entity_encoding_notifications', true);
    }
};
