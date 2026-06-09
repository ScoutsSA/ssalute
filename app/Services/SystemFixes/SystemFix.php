<?php

namespace App\Services\SystemFixes;

/**
 * A single, idempotent data-integrity fix run by the `app:system-fixes` command.
 *
 * Implementations should be safe to run repeatedly: when the data is already in
 * the expected state, run() must make no changes and return an empty result.
 */
interface SystemFix
{
    public function label(): string;

    /**
     * The boolean property on DataFixesSettings that toggles this fix on or off.
     */
    public function settingKey(): string;

    /**
     * The boolean property on DataFixesSettings that toggles Slack notifications
     * for this fix on or off.
     */
    public function notificationSettingKey(): string;

    public function run(): SystemFixResult;
}
