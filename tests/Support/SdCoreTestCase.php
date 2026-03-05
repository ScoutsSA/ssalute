<?php

namespace Tests\Support;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Base test case for tests that need the sd-core tables (system_users, system_user_types, etc.).
 *
 * The sd-core testing tables are created by the testing migration
 * 2025_09_10_000000_create_sd_core_testing_tables.php which lives in the standard migrations
 * path and is guarded to only run in the testing environment.
 */
abstract class SdCoreTestCase extends TestCase
{
    use RefreshDatabase;
}
