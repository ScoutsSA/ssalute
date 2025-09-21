<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('form.aam_next_in_line_role_national', null);
        $this->migrator->add('form.aam_next_in_line_role_regional', null);
        $this->migrator->add('form.aam_next_in_line_role_district', null);
        $this->migrator->add('form.aam_next_in_line_role_group', null);
        $this->migrator->add('form.aam_approval_role_national', null);
        $this->migrator->add('form.aam_approval_role_regional', null);
        $this->migrator->add('form.aam_approval_role_district', null);
        $this->migrator->add('form.aam_approval_role_group', null);
    }
};
