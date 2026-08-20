<?php

namespace Tests\Feature\Console;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Providers\AppServiceProvider;
use App\Services\SystemFixes\FlagUsersWithoutRoleInHomeLocation;
use App\Settings\DataFixesSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Tests\Support\SdCoreTestCase;

class FlagUsersWithoutRoleInHomeLocationTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Isolate this fix: turn the other registered fix off so alert assertions
        // are only ever about the home-location fix.
        app(DataFixesSettings::class)->fill([
            'ensure_each_user_has_only_one_primary_role_enabled' => false,
            'flag_users_without_role_in_home_location_enabled' => true,
            'flag_users_without_role_in_home_location_notifications' => true,
            'notifications_enabled' => true,
            'slack_webhook_url' => 'https://hooks.slack.com/services/T000/B000/data-fixes',
        ])->save();
    }

    #[Test]
    public function it_flags_a_user_whose_only_role_is_in_a_different_group_than_home(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);

        $this->artisan('app:system-fixes')->assertSuccessful();

        // Slack carries a count and a link; the member detail lives on the Data Fixes page.
        SlackAlert::expectMessageSentContaining('1 item outstanding.');
        SlackAlert::expectMessageSentContaining('Review and fix');
        $this->assertFindingFor($user, 'are elsewhere');
    }

    #[Test]
    public function each_flagged_member_links_to_their_edit_page(): void
    {
        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);

        $finding = app(FlagUsersWithoutRoleInHomeLocation::class)->findings()->sole();

        $this->assertStringContainsString((string) $user->id, (string) $finding->title);
        $this->assertNotNull($finding->url, 'The finding must link somewhere an admin can act.');
        $this->assertStringContainsString("/backoffice/users/{$user->id}/edit", $finding->url);
    }

    #[Test]
    public function it_flags_a_multi_role_user_with_roles_only_in_other_groups(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);
        $this->groupRole($user, groupId: 300);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectMessageSentContaining('1 item outstanding.');
        $this->assertFindingFor($user, 'active area role(s) are elsewhere');
    }

    #[Test]
    public function it_does_not_flag_a_user_who_has_at_least_one_role_at_home(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);
        $this->groupRole($user, groupId: 100);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_flag_a_user_with_no_home_location(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create([
            'assoc_to_group' => 0,
            'assoc_to_district' => 0,
            'assoc_to_region' => 0,
        ]);
        $this->groupRole($user, groupId: 200);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function a_district_role_at_the_users_home_district_anchors_the_user(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create(['assoc_to_group' => 0, 'assoc_to_district' => 5]);
        SystemUsersOtherRole::factory()->create([
            'userID' => $user->id,
            'roleID' => SystemUserType::factory()->district()->create()->id,
            'districtID' => 5,
            'active' => 1,
        ]);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_ignores_roles_that_carry_no_area_of_their_own(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        SystemUsersOtherRole::factory()->create([
            'userID' => $user->id,
            'roleID' => SystemUserType::factory()->create([
                'groupRole' => 0,
                'nationalRole' => 1,
            ])->id,
            'active' => 1,
        ]);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_never_changes_any_data(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $roleId = $this->groupRole($user, groupId: 200);

        $this->artisan('app:system-fixes')->assertSuccessful();

        $row = $this->connection()->table('system_users_other_roles')->where('id', $roleId)->first();
        $this->assertSame(200, (int) $row->groupID);
        $this->assertSame(1, (int) $row->active);
        $this->assertSame(100, (int) $this->connection()->table('system_users')->where('id', $user->id)->value('assoc_to_group'));
    }

    #[Test]
    public function it_is_skipped_when_the_fix_is_disabled(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['flag_users_without_role_in_home_location_enabled' => false])->save();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_global_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['notifications_enabled' => false])->save();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_per_fix_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['flag_users_without_role_in_home_location_notifications' => false])->save();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_no_webhook_is_configured(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill(['slack_webhook_url' => null])->save();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function a_member_whose_home_group_is_a_rover_crew_is_not_flagged(): void
    {
        // A Rover's home is their crew while their scouting role sits at an ordinary group.
        // That mismatch is their normal state, not a defect.
        $crew = $this->group(id: 400, sections: ['hasRovers' => 1]);
        $user = SystemUser::factory()->create(['assoc_to_group' => $crew]);
        $this->groupRole($user, groupId: 200);

        $this->assertCount(0, app(FlagUsersWithoutRoleInHomeLocation::class)->findings());
    }

    #[Test]
    public function a_member_whose_home_group_is_an_ordinary_group_is_still_flagged(): void
    {
        // The control: without this, the exclusion above could be passing because nothing is
        // ever flagged rather than because crews specifically are skipped.
        $group = $this->group(id: 401, sections: ['hasScouts' => 1]);
        $user = SystemUser::factory()->create(['assoc_to_group' => $group]);
        $this->groupRole($user, groupId: 200);

        $this->assertCount(1, app(FlagUsersWithoutRoleInHomeLocation::class)->findings());
    }

    #[Test]
    public function a_member_whose_home_group_runs_rovers_alongside_another_section_is_still_flagged(): void
    {
        // The boundary. Only a crew — rovers and nothing else — is exempt. A group that happens
        // to run a crew as well as a troop is an ordinary group, and a member with no role there
        // is the case this fix exists to find.
        $group = $this->group(id: 402, sections: ['hasRovers' => 1, 'hasScouts' => 1]);
        $user = SystemUser::factory()->create(['assoc_to_group' => $group]);
        $this->groupRole($user, groupId: 200);

        $this->assertCount(1, app(FlagUsersWithoutRoleInHomeLocation::class)->findings());
    }

    #[Test]
    public function listing_findings_writes_nothing_to_the_log(): void
    {
        // The Data Fixes page calls findings() on every load. A log line per finding would put a
        // warning in the log for every flagged member each time somebody looked at the list.
        $group = $this->group(id: 403, sections: ['hasScouts' => 1]);
        $user = SystemUser::factory()->create(['assoc_to_group' => $group]);
        $this->groupRole($user, groupId: 200);

        Log::spy();

        $findings = app(FlagUsersWithoutRoleInHomeLocation::class)->findings();

        $this->assertCount(1, $findings, 'The fixture must produce a finding, or this proves nothing.');
        Log::shouldNotHaveReceived('warning');
        Log::shouldNotHaveReceived('info');
        Log::shouldNotHaveReceived('error');
    }

    private function groupRole(SystemUser $user, int $groupId): int
    {
        return SystemUsersOtherRole::factory()->create([
            'userID' => $user->id,
            'roleID' => SystemUserType::factory()->group()->create()->id,
            'groupID' => $groupId,
            'active' => 1,
        ])->id;
    }

    private function connection()
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }

    /**
     * @param  array<string, int>  $sections
     */
    private function group(int $id, array $sections): int
    {
        $required = DB::connection(AppServiceProvider::DB_SD_CORE)->select(
            "select COLUMN_NAME n, DATA_TYPE t from information_schema.COLUMNS
             where TABLE_SCHEMA = DATABASE() and TABLE_NAME = 'groups'
               and IS_NULLABLE = 'NO' and COLUMN_DEFAULT is null
               and EXTRA not like '%auto_increment%'",
        );

        $row = [];

        foreach ($required as $column) {
            $row[$column->n] = match ($column->t) {
                'int', 'bigint', 'mediumint', 'smallint', 'tinyint', 'decimal', 'double', 'float' => 0,
                'date' => '2020-01-01',
                'datetime', 'timestamp' => '2020-01-01 00:00:00',
                default => '',
            };
        }

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('groups')->insert(array_merge(
            $row,
            ['hasMeerkats' => 0, 'hasCubs' => 0, 'hasScouts' => 0, 'hasRovers' => 0],
            $sections,
            ['id' => $id, 'name' => "Group {$id}"],
        ));

        return $id;
    }

    private function assertFindingFor(SystemUser $user, string $needle): void
    {
        $findings = app(FlagUsersWithoutRoleInHomeLocation::class)->findings();
        $match = $findings->first(fn ($f) => str_contains($f->title, "#{$user->id}"));

        $this->assertNotNull($match, 'Expected a finding for the flagged member.');
        $this->assertStringContainsString($needle, $match->detail);
    }
}
