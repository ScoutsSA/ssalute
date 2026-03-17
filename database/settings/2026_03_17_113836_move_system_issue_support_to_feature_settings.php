<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('feature.system_issue_support_enabled', false);
        $this->migrator->add('feature.system_issue_support_user_ids', []);

        if ($this->migrator->exists('general.system_issue_support_enabled')) {
            $this->migrator->delete('general.system_issue_support_enabled');
        }

        if ($this->migrator->exists('general.system_issue_support_user_ids')) {
            $this->migrator->delete('general.system_issue_support_user_ids');
        }
    }
};
