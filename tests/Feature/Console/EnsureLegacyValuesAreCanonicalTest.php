<?php

namespace Tests\Feature\Console;

use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use App\Services\SystemFixes\EnsureLegacyValuesAreCanonical;
use App\Settings\DataFixesSettings;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Tests\Support\SdCoreTestCase;

class EnsureLegacyValuesAreCanonicalTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Isolate this fix: turn the other registered fixes off so alert
        // assertions are only ever about this one.
        app(DataFixesSettings::class)->fill([
            'ensure_each_user_has_only_one_primary_role_enabled' => false,
            'flag_users_without_role_in_home_location_enabled' => false,
            'ensure_youth_member_ids_are_in_sync_enabled' => false,
            'ensure_legacy_values_are_canonical_enabled' => true,
            'ensure_legacy_values_are_canonical_notifications' => true,
            'notifications_enabled' => true,
            'slack_webhook_url' => 'https://hooks.slack.com/services/T000/B000/data-fixes',
        ])->save();
    }

    /*
     * Pass 1 — trimming. Unconditional, automatic, and it needs to know nothing
     * about what the column means.
     */

    #[Test]
    public function it_strips_leading_and_trailing_whitespace_from_member_text_fields(): void
    {
        SlackAlert::fake();

        $user = $this->userWith([
            'first_name' => ' Kayden',
            'otherName' => '  Liam Roger',
            'SSANumber' => '140396 ',
        ]);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));
        $this->assertSame('Liam Roger', $this->column('system_users', $user->id, 'otherName'));
        $this->assertSame('140396', $this->column('system_users', $user->id, 'SSANumber'));

        SlackAlert::expectMessageSentContaining('Fixed automatically: 3 changes.');
        SlackAlert::expectMessageSentContaining('Review and fix');
    }

    #[Test]
    public function it_strips_whitespace_from_group_columns_too(): void
    {
        SlackAlert::fake();

        $groupId = 4242;

        $this->insertRow('groups', [
            'id' => $groupId,
            'name' => '1st Rondebosch',
            'gpsLat' => '-26.2041 ',
            'gpsLon' => ' 28.0473',
            'branchCode' => 'JHB ',
        ]);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('-26.2041', $this->column('groups', $groupId, 'gpsLat'));
        $this->assertSame('28.0473', $this->column('groups', $groupId, 'gpsLon'));
        $this->assertSame('JHB', $this->column('groups', $groupId, 'branchCode'));

        SlackAlert::expectMessageSentContaining('Fixed automatically:');
    }

    #[Test]
    public function it_trims_a_race_that_is_a_known_case(): void
    {
        SlackAlert::fake();

        $user = $this->userWith(['race' => 'African ']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('African', $this->column('system_users', $user->id, 'race'));

        SlackAlert::expectMessageSentContaining('Fixed automatically: 1 change.');
    }

    #[Test]
    public function it_trims_a_race_that_is_not_a_known_case_and_still_reports_it(): void
    {
        SlackAlert::fake();

        $user = $this->userWith(['race' => 'Martian ']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        // Trimming is correct regardless of validity; the two passes are independent.
        $this->assertSame('Martian', $this->column('system_users', $user->id, 'race'));

        SlackAlert::expectMessageSentContaining('Fixed automatically: 1 change.');
        SlackAlert::expectMessageSentContaining('1 item outstanding.');
    }

    #[Test]
    public function it_leaves_already_clean_values_untouched_and_sends_no_alert(): void
    {
        SlackAlert::fake();

        $user = $this->userWith([
            'first_name' => 'Kayden',
            'otherName' => 'Liam Roger',
            'SSANumber' => '140396',
            'race' => 'African',
        ]);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));
        $this->assertSame('African', $this->column('system_users', $user->id, 'race'));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_is_idempotent_across_consecutive_runs(): void
    {
        $user = $this->userWith(['first_name' => ' Kayden', 'race' => 'African ']);

        $this->artisan('app:system-fixes')->assertSuccessful();
        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));

        SlackAlert::fake();

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));
        $this->assertSame('African', $this->column('system_users', $user->id, 'race'));
        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_stamp_modified_or_write_an_audit_row(): void
    {
        SlackAlert::fake();

        $user = $this->userWith(['first_name' => ' Kayden']);

        // Anchored well in the past: stamped at now() by the factory, a re-stamp during the
        // same second would be indistinguishable from leaving it alone.
        $this->connection()->table('system_users')->where('id', $user->id)
            ->update(['modified' => '2020-01-01 00:00:00']);

        $auditsBefore = $this->auditCount($user);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));
        $this->assertSame('2020-01-01 00:00:00', $this->column('system_users', $user->id, 'modified'));
        $this->assertSame($auditsBefore, $this->auditCount($user));
    }

    /*
     * Pass 2 — validating enum-backed columns. Reported for an admin, never guessed at.
     */

    #[Test]
    public function it_reports_an_unrecognised_race_without_changing_it(): void
    {
        SlackAlert::fake();

        $user = $this->userWith(['race' => 'Martian']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Martian', $this->column('system_users', $user->id, 'race'));

        $this->assertFinding('race is "Martian", which is not a recognised User Race.');
    }

    #[Test]
    public function it_reports_a_case_variant_because_php_enums_are_case_sensitive(): void
    {
        SlackAlert::fake();

        // The column's collation is case-insensitive, so only a byte-exact comparison sees
        // that UserRace::tryFrom('african') is null.
        $user = $this->userWith(['race' => 'african']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('african', $this->column('system_users', $user->id, 'race'));

        $this->assertFinding('race is "african", which is not a recognised User Race.');
    }

    #[Test]
    public function it_counts_every_row_holding_the_same_unrecognised_value(): void
    {
        SlackAlert::fake();

        $this->userWith(['race' => 'Martian']);
        $this->userWith(['race' => 'Martian']);
        $this->userWith(['race' => 'Martian']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectMessageSentContaining('3 items outstanding.');
    }

    #[Test]
    public function it_does_not_report_a_race_the_same_run_has_just_trimmed_into_shape(): void
    {
        $user = $this->userWith(['race' => 'African ']);

        $result = app(EnsureLegacyValuesAreCanonical::class)->run();

        $this->assertSame('African', $this->column('system_users', $user->id, 'race'));

        // The validate pass runs after the trim, so the repaired value is never raised.
        $this->assertNotEmpty($result->changes, 'The check is vacuous if nothing was trimmed.');
        $this->assertSame([], $result->attentions);
    }

    #[Test]
    public function it_clears_an_unrecognised_title_rather_than_asking_an_admin(): void
    {
        SlackAlert::fake();

        // Live data holds 204 "Not Set" and 112 "External Booking" here: sentinels legacy wrote
        // where a title belongs. A courtesy prefix is not worth a worklist item, so the fix
        // empties it instead of queueing 319 identical decisions for a human.
        $user = $this->userWith(['title' => 'Not Set']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertNull($this->column('system_users', $user->id, 'title'));

        // Counted as an automatic fix, and it leaves nothing on the worklist.
        SlackAlert::expectMessageSentContaining('Fixed automatically: 1 change.');
        $this->assertSame([], app(EnsureLegacyValuesAreCanonical::class)->findings()->all());

        $changes = app(EnsureLegacyValuesAreCanonical::class)->run()->changes;
        $this->assertSame([], $changes, 'A second run must have nothing left to clear.');
    }

    #[Test]
    public function a_clearable_column_never_appears_on_the_worklist_even_before_a_run(): void
    {
        // The page calls findings() directly, so between nightly runs an unrecognised title is
        // still sitting in the column. It must not show up as work for a human, because the next
        // run will clear it. Asserting this after a run would prove nothing — the run has already
        // emptied the column by then.
        $this->userWith(['title' => 'Not Set', 'race' => 'Martian']);

        $findings = app(EnsureLegacyValuesAreCanonical::class)->findings();

        $this->assertNotEmpty($findings, 'The check is vacuous if nothing is reported at all.');
        $this->assertSame(
            ['race is "Martian", which is not a recognised User Race.'],
            $findings->map(fn ($f) => $f->detail)->all(),
        );
    }

    #[Test]
    public function it_leaves_a_recognised_title_alone(): void
    {
        // The control: without it, "the bad title was cleared" would also pass on an
        // implementation that empties the column for everybody.
        $user = $this->userWith(['title' => 'Mrs']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Mrs', $this->column('system_users', $user->id, 'title'));
    }

    #[Test]
    public function clearing_a_title_does_not_touch_a_column_that_is_reported_rather_than_cleared(): void
    {
        // race and title are both enum-backed on the same table; only title is disposable.
        $user = $this->userWith(['title' => 'Not Set', 'race' => 'Martian']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertNull($this->column('system_users', $user->id, 'title'));
        $this->assertSame('Martian', $this->column('system_users', $user->id, 'race'));
        $this->assertFinding('race is "Martian", which is not a recognised User Race.');
    }

    #[Test]
    public function it_reports_an_unrecognised_value_on_an_int_backed_enum(): void
    {
        SlackAlert::fake();

        // GroupTypes covers 1-6. An int column needs a different predicate from a string one:
        // `col <> ''` would coerce to `col <> 0` and CAST(col AS BINARY) would compare a binary
        // string against an int parameter.
        $groupId = 4243;
        $this->insertRow('groups', ['id' => $groupId, 'name' => '2nd Rondebosch', 'groupTypeID' => 99]);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertFinding('groupTypeID is "99", which is not a recognised Group Types.');
    }

    #[Test]
    public function it_reports_a_zero_on_an_int_backed_enum_that_has_no_zero_case(): void
    {
        SlackAlert::fake();

        // The anti-coercion case specifically: GroupTypes has no case backed by 0, so a stored
        // 0 is invalid and must be reported. A `col <> ''` predicate would silently skip it.
        $groupId = 4244;
        $this->insertRow('groups', ['id' => $groupId, 'name' => '3rd Rondebosch', 'groupTypeID' => 0]);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertFinding('groupTypeID is "0", which is not a recognised Group Types.');
    }

    #[Test]
    public function every_string_backed_enum_column_is_also_trimmed(): void
    {
        // Whitespace on an enum column would otherwise surface as an "unrecognised value" the
        // admin cannot act on, because the value is right and only its padding is wrong. The
        // two lists are declared separately, so this guards them against drifting apart.
        $trimmed = collect($this->constant('TRIM_COLUMNS'))
            ->flatMap(fn (array $columns, string $table) => array_map(fn ($c) => "{$table}.{$c}", $columns))
            ->all();

        foreach ($this->constant('ENUM_COLUMNS') as $target) {
            // Keyed off the COLUMN's type, not the enum's: GroupTypes is string-backed over an
            // int column, and trimming an int column is meaningless.
            if (! $this->isTextColumn($target['table'], $target['column'])) {
                continue;
            }

            $this->assertContains(
                "{$target['table']}.{$target['column']}",
                $trimmed,
                "{$target['table']}.{$target['column']} is validated as an enum but never trimmed.",
            );
        }
    }

    /*
     * Toggles.
     */

    #[Test]
    public function it_is_skipped_when_the_fix_is_disabled(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill([
            'ensure_legacy_values_are_canonical_enabled' => false,
        ])->save();

        $user = $this->userWith(['first_name' => ' Kayden']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(' Kayden', $this->column('system_users', $user->id, 'first_name'));
        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_global_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['notifications_enabled' => false])->save();

        $user = $this->userWith(['first_name' => ' Kayden']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        // The fix still runs; only the announcement is suppressed.
        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));
        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_per_fix_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill([
            'ensure_legacy_values_are_canonical_notifications' => false,
        ])->save();

        $user = $this->userWith(['first_name' => ' Kayden']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));
        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_no_webhook_is_configured(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['slack_webhook_url' => null])->save();

        $user = $this->userWith(['first_name' => ' Kayden']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Kayden', $this->column('system_users', $user->id, 'first_name'));
        SlackAlert::expectNoMessagesSent();
    }

    /*
     * The read path. The Data Fixes page calls findings() on every load, so what
     * findings() is allowed to do is a property of the page, not of the fix.
     */

    #[Test]
    public function listing_findings_writes_nothing_to_the_log(): void
    {
        $this->insertRow('groups', ['name' => 'Bad Type', 'groupTypeID' => 99]);

        Log::spy();

        $findings = app(EnsureLegacyValuesAreCanonical::class)->findings();

        $this->assertCount(1, $findings);
        Log::shouldNotHaveReceived('warning');
        Log::shouldNotHaveReceived('info');
        Log::shouldNotHaveReceived('error');
    }

    #[Test]
    public function a_column_with_more_offenders_than_the_cap_says_so_rather_than_truncating(): void
    {
        $cap = (new ReflectionClass(EnsureLegacyValuesAreCanonical::class))
            ->getConstant('RECORDS_PER_COLUMN');

        $this->insertRows('groups', $cap + 3, fn (int $i): array => [
            'name' => "Bad Type {$i}",
            'groupTypeID' => 99,
        ]);

        $findings = app(EnsureLegacyValuesAreCanonical::class)
            ->findings()
            ->filter(fn ($finding): bool => $finding->group === 'groups.groupTypeID');

        // The cap still applies — the page does not render 503 rows...
        $this->assertCount($cap + 1, $findings);

        // ...but the three it left out are stated, not swallowed.
        $overflow = $findings->last();
        $this->assertSame('3 more not listed', $overflow->title);
        $this->assertStringContainsString((string) ($cap + 3), $overflow->detail);
        $this->assertNull($overflow->url);
    }

    #[Test]
    public function a_column_exactly_at_the_cap_does_not_claim_an_overflow(): void
    {
        $cap = (new ReflectionClass(EnsureLegacyValuesAreCanonical::class))
            ->getConstant('RECORDS_PER_COLUMN');

        $this->insertRows('groups', $cap, fn (int $i): array => [
            'name' => "Bad Type {$i}",
            'groupTypeID' => 99,
        ]);

        $findings = app(EnsureLegacyValuesAreCanonical::class)
            ->findings()
            ->filter(fn ($finding): bool => $finding->group === 'groups.groupTypeID');

        $this->assertCount($cap, $findings);
        $this->assertStringNotContainsString('not listed', $findings->last()->title);
    }

    /**
     * Bulk-insert legacy rows. Derives the NOT NULL placeholders once rather than per row, so a
     * fixture large enough to exercise the cap does not cost 500 information_schema queries.
     *
     * @param  callable(int): array<string, string|int|null>  $values
     */
    private function insertRows(string $table, int $count, callable $values): void
    {
        $rows = [];

        for ($i = 0; $i < $count; $i++) {
            $rows[] = $values($i);
        }

        $required = $this->connection()->select(
            "select COLUMN_NAME n, DATA_TYPE t from information_schema.COLUMNS
             where TABLE_SCHEMA = DATABASE() and TABLE_NAME = ?
               and IS_NULLABLE = 'NO' and COLUMN_DEFAULT is null
               and EXTRA not like '%auto_increment%'",
            [$table],
        );

        $placeholders = [];

        foreach ($required as $column) {
            if (array_key_exists($column->n, $rows[0])) {
                continue;
            }

            $placeholders[$column->n] = match ($column->t) {
                'int', 'bigint', 'mediumint', 'smallint', 'tinyint', 'decimal', 'double', 'float' => 0,
                'date' => '2020-01-01',
                'datetime', 'timestamp' => '2020-01-01 00:00:00',
                default => '',
            };
        }

        $this->connection()->table($table)->insert(
            array_map(fn (array $row): array => array_merge($placeholders, $row), $rows),
        );
    }

    /**
     * Seed raw column values, bypassing the models' own mutators.
     *
     * @param  array<string, string|null>  $values
     */
    private function userWith(array $values): SystemUser
    {
        $user = SystemUser::factory()->create();

        $this->connection()
            ->table('system_users')
            ->where('id', $user->id)
            ->update($values);

        return $user;
    }

    /**
     * Insert a legacy row, filling in whatever the schema insists on.
     *
     * The legacy tables carry many NOT NULL columns with no default, and which ones is not
     * stable enough to hard-code — so the placeholders are derived from information_schema
     * rather than listed here.
     *
     * @param  array<string, string|int|null>  $values
     */
    private function insertRow(string $table, array $values): void
    {
        $required = $this->connection()->select(
            "select COLUMN_NAME n, DATA_TYPE t from information_schema.COLUMNS
             where TABLE_SCHEMA = DATABASE() and TABLE_NAME = ?
               and IS_NULLABLE = 'NO' and COLUMN_DEFAULT is null
               and EXTRA not like '%auto_increment%'",
            [$table],
        );

        $placeholders = [];

        foreach ($required as $column) {
            if (array_key_exists($column->n, $values)) {
                continue;
            }

            $placeholders[$column->n] = match ($column->t) {
                'int', 'bigint', 'mediumint', 'smallint', 'tinyint', 'decimal', 'double', 'float' => 0,
                'date' => '2020-01-01',
                'datetime', 'timestamp' => '2020-01-01 00:00:00',
                default => '',
            };
        }

        $this->connection()->table($table)->insert(array_merge($placeholders, $values));
    }

    private function column(string $table, int $id, string $column): ?string
    {
        return $this->connection()
            ->table($table)
            ->where('id', $id)
            ->value($column);
    }

    private function auditCount(SystemUser $user): int
    {
        return $this->connection()
            ->table('ssalute_audits')
            ->where('auditable_type', SystemUser::class)
            ->where('auditable_id', $user->id)
            ->count();
    }

    private function assertFinding(string $detail): void
    {
        $details = app(EnsureLegacyValuesAreCanonical::class)->findings()
            ->map(fn ($f) => $f->detail)->all();

        $this->assertContains($detail, $details, 'Findings were: ' . json_encode($details));
    }

    private function isTextColumn(string $table, string $column): bool
    {
        $type = $this->connection()->selectOne(
            'select DATA_TYPE t from information_schema.COLUMNS
             where TABLE_SCHEMA = DATABASE() and TABLE_NAME = ? and COLUMN_NAME = ?',
            [$table, $column],
        );

        return in_array($type?->t, ['varchar', 'char', 'text'], true);
    }

    /**
     * @return array<array-key, mixed>
     */
    private function constant(string $name): array
    {
        return (new ReflectionClass(EnsureLegacyValuesAreCanonical::class))->getConstant($name);
    }

    private function connection(): ConnectionInterface
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }
}
