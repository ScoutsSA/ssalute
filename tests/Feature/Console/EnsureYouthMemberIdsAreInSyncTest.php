<?php

namespace Tests\Feature\Console;

use App\Providers\AppServiceProvider;
use App\Services\SystemFixes\EnsureYouthMemberIdsAreInSync;
use App\Settings\DataFixesSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Tests\Support\SdCoreTestCase;

class EnsureYouthMemberIdsAreInSyncTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Isolate this fix: turn the other registered fixes off so alert
        // assertions are only ever about the member-id sync fix.
        app(DataFixesSettings::class)->fill([
            'ensure_each_user_has_only_one_primary_role_enabled' => false,
            'flag_users_without_role_in_home_location_enabled' => false,
            'ensure_youth_member_ids_are_in_sync_enabled' => true,
            'ensure_youth_member_ids_are_in_sync_notifications' => true,
            'notifications_enabled' => true,
            'slack_webhook_url' => 'https://hooks.slack.com/services/T000/B000/data-fixes',
        ])->save();
    }

    #[Test]
    public function it_backfills_a_null_user_id_from_the_scout_id(): void
    {
        SlackAlert::fake();

        $id = $this->insertScoutBadge(scoutID: 555, userID: null);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(555, $this->column('badges_scouts', $id, 'userID'));

        // Slack carries a count and a link; the per-record detail lives on the Data Fixes page.
        SlackAlert::expectMessageSentContaining('Fixed automatically: 1 change.');
        SlackAlert::expectMessageSentContaining('Review and fix');
    }

    #[Test]
    public function it_backfills_a_null_meerkat_id_from_the_user_id(): void
    {
        SlackAlert::fake();

        $id = $this->insertMeerkatBadge(meerkatID: null, userID: 777);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(777, $this->column('badges_meerkats', $id, 'meerkatID'));

        SlackAlert::expectMessageSentContaining('Fixed automatically: 1 change.');
    }

    #[Test]
    public function it_flags_a_conflict_when_both_columns_are_set_but_disagree(): void
    {
        SlackAlert::fake();

        $id = $this->insertScoutBadge(scoutID: 111, userID: 222);

        $this->artisan('app:system-fixes')->assertSuccessful();

        // Left untouched: the fix must not guess which id is correct.
        $this->assertSame(111, $this->column('badges_scouts', $id, 'scoutID'));
        $this->assertSame(222, $this->column('badges_scouts', $id, 'userID'));

        SlackAlert::expectMessageSentContaining('1 item outstanding.');

        $finding = app(EnsureYouthMemberIdsAreInSync::class)->findings()->sole();
        $this->assertSame("badges_scouts #{$id}", $finding->title);
        $this->assertStringContainsString('disagree', $finding->detail);
        $this->assertStringContainsString('/backoffice/users/222/edit', $finding->url);
    }

    #[Test]
    public function it_leaves_already_synced_records_untouched_and_sends_no_alert(): void
    {
        SlackAlert::fake();

        $id = $this->insertScoutBadge(scoutID: 333, userID: 333);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(333, $this->column('badges_scouts', $id, 'userID'));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_is_skipped_when_the_fix_is_disabled(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['ensure_youth_member_ids_are_in_sync_enabled' => false])->save();

        $id = $this->insertScoutBadge(scoutID: 444, userID: null);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertNull($this->column('badges_scouts', $id, 'userID'));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_global_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['notifications_enabled' => false])->save();

        $id = $this->insertScoutBadge(scoutID: 666, userID: null);

        $this->artisan('app:system-fixes')->assertSuccessful();

        // The fix still runs and repairs the data; only the alert is suppressed.
        $this->assertSame(666, $this->column('badges_scouts', $id, 'userID'));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_per_fix_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['ensure_youth_member_ids_are_in_sync_notifications' => false])->save();

        $this->insertScoutBadge(scoutID: 888, userID: null);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_no_webhook_is_configured(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['slack_webhook_url' => null])->save();

        $this->insertScoutBadge(scoutID: 999, userID: null);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function listing_findings_writes_nothing_to_the_log(): void
    {
        // The Data Fixes page calls findings() on every load, so the read path must stay silent.
        $this->insertScoutBadge(scoutID: 555, userID: 777);

        Log::spy();

        $findings = app(EnsureYouthMemberIdsAreInSync::class)->findings();

        $this->assertCount(1, $findings, 'The fixture must produce a conflict, or this proves nothing.');
        Log::shouldNotHaveReceived('warning');
        Log::shouldNotHaveReceived('info');
        Log::shouldNotHaveReceived('error');
    }

    private function insertScoutBadge(int $scoutID, ?int $userID): int
    {
        return $this->connection()->table('badges_scouts')->insertGetId([
            'assocToGroup' => 97,
            'scoutID' => $scoutID,
            'userID' => $userID,
            'firstID' => 140,
            'badgeDate' => '2026-05-26',
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ]);
    }

    private function insertMeerkatBadge(?int $meerkatID, int $userID): int
    {
        return $this->connection()->table('badges_meerkats')->insertGetId([
            'assocToGroup' => 97,
            'meerkatID' => $meerkatID,
            'userID' => $userID,
            'firstID' => 1,
            'badgeDate' => '2026-05-26',
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ]);
    }

    private function column(string $table, int $id, string $column): ?int
    {
        $value = $this->connection()->table($table)->where('id', $id)->value($column);

        return $value === null ? null : (int) $value;
    }

    private function connection()
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }
}
