<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('feature.users_can_edit_profiles', false);
        $this->migrator->add('feature.users_can_browse_areas', false);
        $this->migrator->add('feature.users_can_upload_profile_photo', false);
        $this->migrator->add('feature.users_can_add_documents', false);
        $this->migrator->add('feature.users_can_add_past_service', false);
        $this->migrator->add('feature.users_can_add_past_training', false);
        $this->migrator->add('feature.users_can_add_awards', false);
        $this->migrator->add('feature.users_can_view_notifications', false);
    }
};
