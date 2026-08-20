<?php

namespace Tests\Feature\Console;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Providers\AppServiceProvider;
use App\Settings\DataFixesSettings;
use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Tests\Support\SdCoreTestCase;

class RunSystemFixesTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app(DataFixesSettings::class)->fill([
            'ensure_each_user_has_only_one_primary_role_enabled' => true,
            'ensure_each_user_has_only_one_primary_role_notifications' => true,
            'notifications_enabled' => true,
            'slack_webhook_url' => 'https://hooks.slack.com/services/T000/B000/data-fixes',
        ])->save();
    }

    #[Test]
    public function it_keeps_the_most_recent_active_primary_role_and_demotes_the_rest(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $olderPrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now()->subYear());
        $newerPrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(0, $this->primaryFlag($olderPrimaryId));
        $this->assertSame(1, $this->primaryFlag($newerPrimaryId));
        $this->assertSame(1, $this->activePrimaryCount($user));

        // Slack carries a count and a link; the per-member detail lives on the Data Fixes page.
        SlackAlert::expectMessageSentContaining('Fixed automatically: 1 change.');
        SlackAlert::expectMessageSentContaining('Review and fix');
    }

    #[Test]
    public function it_demotes_an_inactive_primary_in_favour_of_an_active_one(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $activePrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now());
        $inactivePrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 0, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->primaryFlag($activePrimaryId));
        $this->assertSame(0, $this->primaryFlag($inactivePrimaryId));

        SlackAlert::expectMessageSentContaining('Fixed automatically:');
    }

    #[Test]
    public function it_promotes_an_active_role_when_the_only_primary_is_deactivated(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $activeNonPrimaryId = $this->createRole($user, $roleType, defaultRole: 0, active: 1, created: now());
        $inactivePrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 0, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->primaryFlag($activeNonPrimaryId));
        $this->assertSame(0, $this->primaryFlag($inactivePrimaryId));

        SlackAlert::expectMessageSentContaining('Fixed automatically:');
    }

    #[Test]
    public function it_promotes_a_primary_when_a_user_has_none(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $olderId = $this->createRole($user, $roleType, defaultRole: 0, active: 1, created: now()->subYear());
        $newerId = $this->createRole($user, $roleType, defaultRole: 0, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(0, $this->primaryFlag($olderId));
        $this->assertSame(1, $this->primaryFlag($newerId));

        SlackAlert::expectMessageSentContaining('Fixed automatically:');
    }

    #[Test]
    public function it_demotes_a_deactivated_primary_when_the_user_has_no_active_roles(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $primaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 0, created: now());
        $otherId = $this->createRole($user, $roleType, defaultRole: 0, active: 0, created: now()->subYear());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(0, $this->primaryFlag($primaryId));
        $this->assertSame(0, $this->primaryFlag($otherId));
        $this->assertSame(0, $this->activePrimaryCount($user));

        SlackAlert::expectMessageSentContaining('Fixed automatically:');
    }

    #[Test]
    public function it_leaves_a_user_with_no_active_roles_and_no_primary_untouched(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $firstId = $this->createRole($user, $roleType, defaultRole: 0, active: 0, created: now());
        $secondId = $this->createRole($user, $roleType, defaultRole: 0, active: 0, created: now()->subYear());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(0, $this->primaryFlag($firstId));
        $this->assertSame(0, $this->primaryFlag($secondId));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_leaves_a_valid_single_primary_untouched_and_sends_no_alert(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $primaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now()->subYear());
        $secondaryId = $this->createRole($user, $roleType, defaultRole: 0, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->primaryFlag($primaryId));
        $this->assertSame(0, $this->primaryFlag($secondaryId));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_ignores_inactive_users(): void
    {
        SlackAlert::fake();

        $user = SystemUser::factory()->inactive()->create();
        $roleType = SystemUserType::factory()->create();

        $firstPrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now()->subYear());
        $secondPrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->primaryFlag($firstPrimaryId));
        $this->assertSame(1, $this->primaryFlag($secondPrimaryId));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_skips_a_disabled_fix(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill([
            'ensure_each_user_has_only_one_primary_role_enabled' => false,
        ])->save();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $olderPrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now()->subYear());
        $newerPrimaryId = $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->primaryFlag($olderPrimaryId));
        $this->assertSame(1, $this->primaryFlag($newerPrimaryId));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_global_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill([
            'notifications_enabled' => false,
        ])->save();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now()->subYear());
        $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->activePrimaryCount($user));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_the_per_fix_notification_toggle_is_off(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill([
            'ensure_each_user_has_only_one_primary_role_notifications' => false,
        ])->save();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now()->subYear());
        $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->activePrimaryCount($user));

        SlackAlert::expectNoMessagesSent();
    }

    #[Test]
    public function it_does_not_alert_when_no_webhook_is_configured(): void
    {
        SlackAlert::fake();

        app(DataFixesSettings::class)->fill([
            'slack_webhook_url' => null,
        ])->save();

        $user = SystemUser::factory()->create();
        $roleType = SystemUserType::factory()->create();

        $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now()->subYear());
        $this->createRole($user, $roleType, defaultRole: 1, active: 1, created: now());

        $this->artisan('app:system-fixes')->assertSuccessful();

        $this->assertSame(1, $this->activePrimaryCount($user));

        SlackAlert::expectNoMessagesSent();
    }

    private function createRole(SystemUser $user, SystemUserType $roleType, int $defaultRole, int $active, DateTimeInterface $created): int
    {
        return SystemUsersOtherRole::factory()->create([
            'userID' => $user->id,
            'roleID' => $roleType->id,
            'defaultRole' => $defaultRole,
            'active' => $active,
            'created' => $created,
        ])->id;
    }

    private function primaryFlag(int $roleId): int
    {
        return (int) $this->connection()
            ->table('system_users_other_roles')
            ->where('id', $roleId)
            ->value('defaultRole');
    }

    private function activePrimaryCount(SystemUser $user): int
    {
        return $this->connection()
            ->table('system_users_other_roles')
            ->where('userID', $user->id)
            ->where('active', 1)
            ->where('defaultRole', 1)
            ->count();
    }

    private function connection()
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }
}
