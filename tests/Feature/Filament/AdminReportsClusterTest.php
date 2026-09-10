<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\AdminReports\Pages\MostActiveUsers;
use App\Filament\Admin\Clusters\AdminReports\Pages\NoPrimaryRoles;
use App\Filament\Admin\Clusters\AdminReports\Resources\GoodLogons\GoodLogonResource;
use App\Filament\Admin\Clusters\AdminReports\Resources\GoodLogons\Pages\ListGoodLogons;
use App\Listeners\RecordSuccessfulLogin;
use App\Models\AdminGoodLogon;
use App\Models\SystemUser;
use App\Models\SystemUserLogging;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AdminReportsClusterTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{string}> */
    public static function reportUrlProvider(): array
    {
        return [
            'logins' => ['/backoffice/admin-reports/logins'],
            'most active users' => ['/backoffice/admin-reports/most-active-users'],
            'no primary roles' => ['/backoffice/admin-reports/no-primary-roles'],
            'system contact messages' => ['/backoffice/admin-reports/system-contact-messages'],
        ];
    }

    #[Test]
    #[DataProvider('reportUrlProvider')]
    public function super_admin_can_access_report(string $url): void
    {
        $this->actingAs($this->superAdmin)
            ->get($url)
            ->assertOk();
    }

    #[Test]
    #[DataProvider('reportUrlProvider')]
    public function regular_user_is_forbidden_from_report(string $url): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get($url)
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_from_reports(): void
    {
        $this->get(GoodLogonResource::getUrl('index'))
            ->assertRedirect();
    }

    #[Test]
    public function logins_report_lists_logons_newest_first(): void
    {
        $logons = AdminGoodLogon::factory()->count(3)->create();

        Livewire::actingAs($this->superAdmin)
            ->test(ListGoodLogons::class)
            ->assertOk()
            ->assertCanSeeTableRecords($logons);
    }

    #[Test]
    public function logins_report_filters_by_date(): void
    {
        $old = AdminGoodLogon::factory()->create(['date' => '2026-01-01 08:00:00']);
        $recent = AdminGoodLogon::factory()->create(['date' => '2026-08-20 08:00:00']);

        Livewire::actingAs($this->superAdmin)
            ->test(ListGoodLogons::class)
            ->filterTable('date', ['from' => '2026-06-01', 'until' => '2026-08-31'])
            ->assertCanSeeTableRecords([$recent])
            ->assertCanNotSeeTableRecords([$old]);
    }

    #[Test]
    public function logins_report_searches_by_username(): void
    {
        $alpha = AdminGoodLogon::factory()->create(['username' => 'alpha@example.org']);
        $beta = AdminGoodLogon::factory()->create(['username' => 'beta@example.org']);

        Livewire::actingAs($this->superAdmin)
            ->test(ListGoodLogons::class)
            ->searchTable('alpha@example.org')
            ->assertCanSeeTableRecords([$alpha])
            ->assertCanNotSeeTableRecords([$beta]);
    }

    #[Test]
    public function a_successful_login_is_recorded_in_both_history_tables(): void
    {
        $roleType = SystemUserType::factory()->create();
        $user = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($user)->ofType($roleType)->create([
            'defaultRole' => 1,
            'regionID' => 4,
            'districtID' => 5,
            'groupID' => 6,
        ]);

        Auth::login($user);

        $this->assertDatabaseHas(AdminGoodLogon::class, [
            'username' => $user->username,
            'fromSD' => RecordSuccessfulLogin::FROM_SSALUTE,
            'roleID' => $roleType->id,
            'regionID' => 4,
            'districtID' => 5,
            'groupID' => 6,
        ]);

        $this->assertDatabaseHas(SystemUserLogging::class, [
            'userID' => $user->id,
            'page' => RecordSuccessfulLogin::LOGON_PAGE,
            'regionID' => 4,
            'districtID' => 5,
            'groupID' => 6,
        ]);
    }

    #[Test]
    public function login_recording_copes_with_a_user_without_roles(): void
    {
        $user = SystemUser::factory()->create();

        Auth::login($user);

        $this->assertDatabaseHas(AdminGoodLogon::class, [
            'username' => $user->username,
            'fromSD' => RecordSuccessfulLogin::FROM_SSALUTE,
            'roleID' => 0,
        ]);
    }

    #[Test]
    public function most_active_users_ranks_by_page_views_inside_the_window(): void
    {
        $busy = SystemUser::factory()->create();
        $quiet = SystemUser::factory()->create();
        $stale = SystemUser::factory()->create();

        SystemUserLogging::factory()->count(3)->create(['userID' => $busy->id, 'created' => now()->subDays(2)]);
        SystemUserLogging::factory()->create(['userID' => $busy->id, 'page' => RecordSuccessfulLogin::LOGON_PAGE, 'created' => now()->subDay()]);
        SystemUserLogging::factory()->create(['userID' => $busy->id, 'page' => '/ajax/poll', 'created' => now()->subDay()]);
        SystemUserLogging::factory()->create(['userID' => $quiet->id, 'created' => now()->subDays(3)]);
        SystemUserLogging::factory()->create(['userID' => $stale->id, 'created' => now()->subDays(400)]);

        $component = Livewire::actingAs($this->superAdmin)
            ->test(MostActiveUsers::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$busy, $quiet])
            ->assertCanNotSeeTableRecords([$stale]);

        $records = $component->instance()->getTableRecords();

        $busyRow = $records->firstWhere('id', $busy->id);
        $this->assertSame(4, (int) $busyRow->pages_count);
        $this->assertSame(1, (int) $busyRow->logons_count);
    }

    #[Test]
    public function no_primary_roles_lists_only_active_users_without_an_active_primary_role(): void
    {
        $withPrimary = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($withPrimary)->create(['defaultRole' => 1]);

        $withoutPrimary = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($withoutPrimary)->create(['defaultRole' => 0]);

        $withInactivePrimary = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($withInactivePrimary)->inactive()->create(['defaultRole' => 1]);

        $inactiveUser = SystemUser::factory()->inactive()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(NoPrimaryRoles::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$withoutPrimary, $withInactivePrimary])
            ->assertCanNotSeeTableRecords([$withPrimary, $inactiveUser]);
    }
}
