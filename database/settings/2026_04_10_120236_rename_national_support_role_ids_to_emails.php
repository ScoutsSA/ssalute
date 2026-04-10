<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.national_support_emails', []);

        if ($this->migrator->exists('general.national_support_role_ids')) {
            $this->migrator->delete('general.national_support_role_ids');
        }
    }
};
