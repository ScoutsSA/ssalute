<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Widgets\AttentionWidget;
use App\Filament\Admin\Widgets\PlatformKpisWidget;
use App\Filament\Admin\Widgets\RecentLoginsWidget;
use App\Filament\Admin\Widgets\RecentUpdatesWidget;
use App\Models\AdminGoodLogon;
use App\Models\AmsWarrantInfo;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use ReflectionMethod;
use Tests\Support\SdCoreTestCase;

class BackofficeDashboardTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
        Cache::flush();
    }

    #[Test]
    public function super_admin_can_open_the_dashboard(): void
    {
        $this->actingAs($this->superAdmin)
            ->get('/backoffice')
            ->assertOk();
    }

    #[Test]
    public function regular_user_cannot_open_the_dashboard(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get('/backoffice')
            ->assertForbidden();
    }

    #[Test]
    public function kpis_follow_the_legacy_definitions(): void
    {
        $meerkatType = SystemUserType::factory()->create(['name' => 'Meerkat']);
        $warrantedType = SystemUserType::factory()->create(['adultLeaderRole' => 1, 'warrantedRole' => 1]);
        $helperType = SystemUserType::factory()->create(['adultLeaderRole' => 1, 'warrantedRole' => 0]);
        $parentType = SystemUserType::factory()->create(['name' => 'Parent']);

        $investedYouth = SystemUser::factory()->create(['dateInvested' => '2024-05-01']);
        SystemUsersOtherRole::factory()->forUser($investedYouth)->ofType($meerkatType)->create(['defaultRole' => 1]);

        $uninvestedYouth = SystemUser::factory()->create(['dateInvested' => null]);
        SystemUsersOtherRole::factory()->forUser($uninvestedYouth)->ofType($meerkatType)->create(['defaultRole' => 1]);

        $adult = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($adult)->ofType($warrantedType)->create(['defaultRole' => 1]);

        $helper = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($helper)->ofType($helperType)->create(['defaultRole' => 1]);

        $parent = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($parent)->ofType($parentType)->create(['defaultRole' => 1]);

        $nonPrimaryAdult = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($nonPrimaryAdult)->ofType($warrantedType)->create(['defaultRole' => 0]);

        AmsWarrantInfo::query()->create([
            'userID' => $adult->id,
            'warrantNr' => 'W-1001',
            'issueDate' => now()->subYears(2)->toDateString(),
            'active' => 1,
            'expireDate' => now()->addYear()->toDateString(),
            'createdby' => $this->superAdmin->id,
        ]);
        AmsWarrantInfo::query()->create([
            'userID' => $adult->id,
            'warrantNr' => 'W-1002',
            'issueDate' => now()->subYears(4)->toDateString(),
            'active' => 1,
            'expireDate' => now()->subYear()->toDateString(),
            'createdby' => $this->superAdmin->id,
        ]);

        SystemUser::factory()->create(['lastLoginDate' => now()->subMinutes(10)]);
        SystemUser::factory()->create(['lastLoginDate' => now()->subHours(5)]);

        $method = new ReflectionMethod(PlatformKpisWidget::class, 'computeKpis');
        $kpis = $method->invoke(new PlatformKpisWidget);

        $this->assertSame(1, $kpis['invested_youth']);
        $this->assertSame(1, $kpis['invested_adults']);
        $this->assertSame(2, $kpis['parents_and_helpers']);
        $this->assertSame(1, $kpis['active_warrants']);
        $this->assertSame(1, $kpis['active_last_hour']);
        $this->assertSame(2, $kpis['active_last_day']);
    }

    #[Test]
    public function kpi_widget_renders_the_stats(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(PlatformKpisWidget::class)
            ->assertOk()
            ->assertSee('Invested Youth')
            ->assertSee('Active Warrants')
            ->assertSee('Recently Active');
    }

    #[Test]
    public function attention_widget_lists_outstanding_queues(): void
    {
        $user = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()->forUser($user)->count(2)->create(['defaultRole' => 1]);

        ApplicationAdultMembershipRequest::factory()->create();

        Livewire::actingAs($this->superAdmin)
            ->test(AttentionWidget::class)
            ->assertOk()
            ->assertSee('Primary Roles')
            ->assertSee('Pending AAM Requests');
    }

    #[Test]
    public function attention_widget_shows_the_all_clear_when_nothing_is_outstanding(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(AttentionWidget::class)
            ->assertOk()
            ->assertSee('Nothing is waiting for attention');
    }

    #[Test]
    public function recent_logins_widget_shows_latest_logons_and_links_matching_members(): void
    {
        $member = SystemUser::factory()->create();
        $logon = AdminGoodLogon::factory()->create(['username' => $member->username, 'date' => now()]);

        Livewire::actingAs($this->superAdmin)
            ->test(RecentLoginsWidget::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$logon]);
    }

    #[Test]
    public function recent_updates_widget_shows_audited_changes(): void
    {
        $this->actingAs($this->superAdmin);
        $user = SystemUser::factory()->create();
        $user->update(['first_name' => 'Renamed']);

        Livewire::actingAs($this->superAdmin)
            ->test(RecentUpdatesWidget::class)
            ->assertOk()
            ->assertSee('SystemUser');
    }

    #[Test]
    public function logging_in_refreshes_last_login_date(): void
    {
        $user = SystemUser::factory()->create(['lastLoginDate' => null]);

        Auth::login($user);

        $this->assertNotNull($user->fresh()->lastLoginDate);
        $this->assertTrue($user->fresh()->lastLoginDate->greaterThan(now()->subMinute()));
    }
}
