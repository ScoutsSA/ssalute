<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FormSettings extends Settings
{
    public bool $aam_enabled = false;
    public ?string $aam_national_support_emails = null;

    public ?array $aam_approval_role_national = [];
    public ?array $aam_approval_role_regional = [];
    public ?array $aam_approval_role_district = [];
    public ?array $aam_approval_role_group = [];

    public static function group(): string
    {
        return 'form';
    }
}
