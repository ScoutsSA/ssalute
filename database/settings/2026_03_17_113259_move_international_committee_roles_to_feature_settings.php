<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('feature.international_committee_representative_role_ids', []);

        if ($this->migrator->exists('general.international_committee_representative_role_ids')) {
            $this->migrator->delete('general.international_committee_representative_role_ids');
        }
    }
};
