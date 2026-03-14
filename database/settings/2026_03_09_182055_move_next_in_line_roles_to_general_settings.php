<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->rename('form.aam_next_in_line_role_group', 'general.next_in_line_role_group');
        $this->migrator->rename('form.aam_next_in_line_role_district', 'general.next_in_line_role_district');
        $this->migrator->rename('form.aam_next_in_line_role_regional', 'general.next_in_line_role_regional');
        $this->migrator->rename('form.aam_next_in_line_role_national', 'general.next_in_line_role_national');
    }
};
