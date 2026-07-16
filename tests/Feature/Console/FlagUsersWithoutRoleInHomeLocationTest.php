<?php

namespace Tests\Feature\Console;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Providers\AppServiceProvider;
use App\Settings\DataFixesSettings;
use Illuminate\Support\Facades\DB;
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

        SlackAlert::expectMessageSentContaining("User #{$user->id}");
        SlackAlert::expectMessageSentContaining('none at home');
    }

    #[Test]
    public function it_flags_a_multi_role_user_with_roles_only_in_other_groups(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $this->groupRole($user, groupId: 200);
        $this->groupRole($user, groupId: 300);

        $this->artisan('app:system-fixes')->assertSuccessful();

        SlackAlert::expectMessageSentContaining("User #{$user->id}");
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
}
