<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('form.aam_enabled', false);
        $this->migrator->add('form.aam_national_support_emails', null);
    }
};
