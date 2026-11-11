<?php

namespace Tests\Feature\Console;

use App\Models\Group;
use App\Providers\AppServiceProvider;
use App\Services\SystemFixes\RepairLegacyEntityEncoding;
use App\Settings\DataFixesSettings;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Tests\Support\SdCoreTestCase;

class RepairLegacyEntityEncodingTest extends SdCoreTestCase
{
    private const string FOUR_LAYERS_OF_AMPERSAND = '&amp;amp;amp;amp;';

    private const string UNREPAIRABLE_COORDINATE = '26&deg;01&#039;16.3&amp;amp;amp;amp;quot;S';

    protected function setUp(): void
    {
        parent::setUp();

        app(DataFixesSettings::class)->fill([
            'ensure_each_user_has_only_one_primary_role_enabled' => false,
            'flag_users_without_role_in_home_location_enabled' => false,
            'ensure_youth_member_ids_are_in_sync_enabled' => false,
            'ensure_legacy_values_are_canonical_enabled' => false,
            'repair_legacy_entity_encoding_enabled' => true,
            'repair_legacy_entity_encoding_notifications' => true,
            'notifications_enabled' => true,
            'slack_webhook_url' => 'https://hooks.slack.com/services/T000/B000/data-fixes',
        ])->save();
    }

    #[Test]
    public function it_repairs_a_group_name_showing_leftover_encoding(): void
    {
        SlackAlert::fake();

        $groupId = $this->groupNamed('1st Naruna ' . self::FOUR_LAYERS_OF_AMPERSAND . ' Constantia');

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('1st Naruna & Constantia', $this->column('groups', $groupId, 'name'));

        SlackAlert::expectMessageSentContaining('Fixed automatically: 1 change.');
    }

    #[Test]
    public function it_repairs_a_programme_description_showing_leftover_encoding(): void
    {
        $programId = $this->programWithDescription('Sun heat ' . self::FOUR_LAYERS_OF_AMPERSAND . ' exhaustion');

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Sun heat & exhaustion', $this->column('group_programs', $programId, 'description'));
    }

    #[Test]
    public function it_leaves_values_that_render_correctly_alone_and_sends_no_alert(): void
    {
        SlackAlert::fake();

        $cleanInputGroupId = $this->groupNamed('1st Naruna &amp;amp; Constantia');
        $richTextProgramId = $this->programWithDescription('Sun heat &amp;amp;amp; exhaustion');

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('1st Naruna &amp;amp; Constantia', $this->column('groups', $cleanInputGroupId, 'name'));
        $this->assertSame('Sun heat &amp;amp;amp; exhaustion', $this->column('group_programs', $richTextProgramId, 'description'));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_reports_a_value_it_cannot_safely_repair_and_leaves_it_untouched(): void
    {
        SlackAlert::fake();

        $eventId = $this->eventWithLocation(self::UNREPAIRABLE_COORDINATE);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(self::UNREPAIRABLE_COORDINATE, $this->column('group_events', $eventId, 'locationLat'));

        $findings = app(RepairLegacyEntityEncoding::class)->findings();

        $this->assertCount(1, $findings);
        $this->assertSame('group_events.locationLat', $findings->first()->group);

        SlackAlert::expectMessageSentContaining('1 item outstanding.');
    }

    #[Test]
    public function it_does_not_stamp_modified(): void
    {
        $groupId = $this->groupNamed('Fires ' . self::FOUR_LAYERS_OF_AMPERSAND . ' Cooking');

        $this->connection()->table('groups')->where('id', $groupId)->update(['modified' => '2020-01-01 00:00:00']);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Fires & Cooking', $this->column('groups', $groupId, 'name'));
        $this->assertSame('2020-01-01 00:00:00', $this->column('groups', $groupId, 'modified'));
    }

    #[Test]
    public function it_is_idempotent_across_consecutive_runs(): void
    {
        $this->groupNamed('Fires ' . self::FOUR_LAYERS_OF_AMPERSAND . ' Cooking');

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::fake();

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function listing_findings_writes_nothing_to_the_log(): void
    {
        $this->eventWithLocation(self::UNREPAIRABLE_COORDINATE);

        Log::spy();

        $findings = app(RepairLegacyEntityEncoding::class)->findings();

        $this->assertCount(1, $findings, 'The fixture must produce a finding, or this proves nothing.');
        Log::shouldNotHaveReceived('warning');
    }

    #[Test]
    public function it_is_skipped_when_the_fix_is_disabled(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['repair_legacy_entity_encoding_enabled' => false])->save();

        $stored = 'Fires ' . self::FOUR_LAYERS_OF_AMPERSAND . ' Cooking';
        $groupId = $this->groupNamed($stored);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame($stored, $this->column('groups', $groupId, 'name'));
        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_global_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['notifications_enabled' => false])->save();

        $groupId = $this->groupNamed('Fires ' . self::FOUR_LAYERS_OF_AMPERSAND . ' Cooking');

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Fires & Cooking', $this->column('groups', $groupId, 'name'));
        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_per_fix_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['repair_legacy_entity_encoding_notifications' => false])->save();

        $groupId = $this->groupNamed('Fires ' . self::FOUR_LAYERS_OF_AMPERSAND . ' Cooking');

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Fires & Cooking', $this->column('groups', $groupId, 'name'));
        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_no_webhook_is_configured(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['slack_webhook_url' => null])->save();

        $groupId = $this->groupNamed('Fires ' . self::FOUR_LAYERS_OF_AMPERSAND . ' Cooking');

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame('Fires & Cooking', $this->column('groups', $groupId, 'name'));
        SlackAlert::expectNoMessagesSent();
    }

    private function groupNamed(string $name): int
    {
        return Group::factory()->create(['name' => $name])->id;
    }

    private function programWithDescription(string $description): int
    {
        return $this->insertRow('group_programs', ['title' => 'Programme', 'description' => $description]);
    }

    private function eventWithLocation(string $latitude): int
    {
        return $this->insertRow('group_events', ['name' => 'Camp', 'locationLat' => $latitude]);
    }

    /**
     * Insert a legacy row, filling in whatever the schema insists on.
     *
     * @param  array<string, string|int|null>  $values
     */
    private function insertRow(string $table, array $values): int
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

        return $this->connection()->table($table)->insertGetId(array_merge($placeholders, $values));
    }

    private function column(string $table, int $id, string $column): ?string
    {
        return $this->connection()->table($table)->where('id', $id)->value($column);
    }

    private function connection(): ConnectionInterface
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }
}
