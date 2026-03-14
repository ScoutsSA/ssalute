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
    }
}
