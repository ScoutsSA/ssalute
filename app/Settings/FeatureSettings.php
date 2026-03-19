<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FeatureSettings extends Settings
{
    public bool $users_can_edit_profiles = false;

    public bool $users_can_browse_areas = false;

    public bool $users_can_upload_profile_photo = false;

    public bool $users_can_add_documents = false;

    public bool $users_can_add_past_service = false;

    public bool $users_can_add_past_training = false;

    public bool $users_can_add_awards = false;

    public bool $users_can_view_notifications = false;

    public bool $users_can_report_issues = false;

    public bool $users_can_view_audit_log = false;

    public bool $users_can_generate_membership_certificate = false;

    public ?array $membership_certificate_eligible_role_ids = [];

    public bool $system_issue_support_enabled = false;

    public ?array $system_issue_support_user_ids = [];

    public static function group(): string
    {
        return 'feature';
    }
}
