<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        if ($this->migrator->exists('feature.users_can_request_endorsement')) {
            $this->migrator->delete('feature.users_can_request_endorsement');
        }

        if ($this->migrator->exists('feature.international_committee_representative_role_ids')) {
            $this->migrator->delete('feature.international_committee_representative_role_ids');
        }
    }
};
