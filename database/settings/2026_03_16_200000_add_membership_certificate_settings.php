<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('feature.users_can_generate_membership_certificate', false);
        $this->migrator->add('general.international_committee_representative_role_ids', []);
    }
};
