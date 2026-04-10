<?php

namespace Tests\Support;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Base test case for tests that need the full sd-core schema.
 *
 * On first run (or when the schema is missing), migrateDatabases():
 *   1. Drops all tables
 *   2. Imports the MySQL schema dump (all legacy SD tables)
 *   3. Runs the Ssalute-specific migrations on top
 *
 * When the legacy schema is already present, it skips the expensive dump reload
 * and only runs pending Ssalute migrations — making repeated runs fast.
 *
 * Subsequent tests in the same process use database transactions for isolation.
 */
abstract class SdCoreTestCase extends TestCase
{
    use RefreshDatabase;

    protected function migrateDatabases(): void
    {
        if (! Schema::hasTable('system_users')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            foreach (DB::select('SHOW TABLES') as $tableRow) {
                $tableName = array_values((array) $tableRow)[0];
                Schema::dropIfExists($tableName);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            DB::unprepared(file_get_contents(database_path('schema/sd-core-schema.sql')));
        }

        $this->artisan('migrate', ['--force' => true]);

        // Ensure all Spatie settings properties exist (settings migrations may
        // not re-run if the migration table already records them from a prior run).
        $this->ensureSettingsExist();
    }

    private function ensureSettingsExist(): void
    {
        $required = [
            'general' => [
                'super_user_admin_list' => '[]',
                'national_support_emails' => '[]',
                'next_in_line_role_group' => 'null',
                'next_in_line_role_district' => 'null',
                'next_in_line_role_regional' => 'null',
                'next_in_line_role_national' => 'null',
            ],
            'feature' => [
                'users_can_edit_profiles' => 'false',
                'users_can_browse_areas' => 'false',
                'users_can_upload_profile_photo' => 'false',
                'users_can_add_documents' => 'false',
                'users_can_add_past_service' => 'false',
                'users_can_add_past_training' => 'false',
                'users_can_add_awards' => 'false',
                'users_can_view_notifications' => 'false',
                'users_can_report_issues' => 'false',
                'users_can_view_audit_log' => 'false',
                'users_can_generate_membership_certificate' => 'false',
                'membership_certificate_eligible_role_ids' => '[]',
                'system_issue_support_enabled' => 'false',
                'system_issue_support_user_ids' => '[]',
            ],
        ];

        foreach ($required as $group => $settings) {
            foreach ($settings as $name => $payload) {
                DB::table('ssalute_settings')->updateOrInsert(
                    ['group' => $group, 'name' => $name],
                    ['payload' => $payload, 'locked' => false],
                );
            }
        }
    }
}
