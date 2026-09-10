<?php

namespace Tests\Feature\Filament\Member;

use App\Filament\Member\Clusters\Directory\Pages\GroupTeam;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Settings\FeatureSettings;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class DirectoryTest extends SdCoreTestCase
{
    private const string LISTED_EMAIL = 'listed.leader@directory.test';

    private const string LISTED_CELL = '0821234567';

    private Region $region;

    private District $district;

    private Group $group;

    private SystemUserType $adultLeaderGroupRole;

    private SystemUserType $parentRole;

    protected function setUp(): void
    {
        parent::setUp();

        $features = resolve(FeatureSettings::class);
        $features->users_can_browse_directory = true;
        $features->save();

        $this->region = Region::create(['name' => 'Directory Region', 'description' => '', 'phys_address' => '', 'countryID' => 196, 'active' => 1]);
        $this->district = District::create(['name' => 'Directory District', 'regionID' => $this->region->id, 'countryID' => 196, 'active' => 1, 'created' => now(), 'createdby' => 0]);
        $this->group = Group::create(['name' => 'Directory Group', 'groupTypeID' => 1, 'assoc_to_district' => $this->district->id, 'assoc_to_region' => $this->region->id, 'active' => 1, 'created' => now(), 'createdby' => 0]);

        $this->adultLeaderGroupRole = SystemUserType::factory()->group()->create(['name' => 'Troop Scouter', 'adultLeaderRole' => 1]);
        $this->parentRole = SystemUserType::factory()->create(['name' => 'Parent', 'groupRole' => 0, 'adultLeaderRole' => 0]);
    }

    #[Test]
    public function directory_is_hidden_when_the_feature_is_disabled(): void
    {
        $features = resolve(FeatureSettings::class);
        $features->users_can_browse_directory = false;
        $features->save();

        [$viewer, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/group-team")
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_to_login(): void
    {
        [, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->get("/member/{$tenant->id}/directory/national-team")
            ->assertRedirect('/login');
    }

    #[Test]
    public function adult_leader_sees_names_roles_and_contact_details(): void
    {
        $this->listedGroupLeader();
        [$viewer, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/group-team")
            ->assertOk()
            ->assertSee('Listed Leader')
            ->assertSee('Troop Scouter')
            ->assertSee(self::LISTED_EMAIL)
            ->assertSee(self::LISTED_CELL);
    }

    #[Test]
    public function parent_sees_names_and_roles_but_no_contact_details(): void
    {
        $this->listedGroupLeader();
        [$viewer, $tenant] = $this->viewerWithRole($this->parentRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/group-team")
            ->assertOk()
            ->assertSee('Listed Leader')
            ->assertSee('Troop Scouter')
            ->assertDontSee(self::LISTED_EMAIL)
            ->assertDontSee(self::LISTED_CELL)
            ->assertDontSee('Cell Number');
    }

    #[Test]
    public function parent_viewer_never_loads_contact_columns_from_the_database(): void
    {
        $this->listedGroupLeader();
        [$viewer, $tenant] = $this->viewerWithRole($this->parentRole);

        $this->actingAs($viewer);

        $queries = [];
        DB::listen(function ($query) use (&$queries): void {
            $queries[] = $query->sql;
        });

        $this->get("/member/{$tenant->id}/directory/group-team")->assertOk();

        $userSelects = array_filter($queries, fn (string $sql): bool => str_starts_with($sql, 'select') && str_contains($sql, 'from `system_users` where `system_users`.`id` in'));

        $this->assertNotEmpty($userSelects, 'Expected the directory to eager load users');

        foreach ($userSelects as $sql) {
            $this->assertStringNotContainsString('cellNr', $sql);
            $this->assertStringNotContainsString('username', $sql);
        }
    }

    #[Test]
    public function redacted_members_show_the_word_redacted_to_adult_leaders(): void
    {
        $this->listedGroupLeader(['infoRedacted' => 1]);
        [$viewer, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/group-team")
            ->assertOk()
            ->assertSee('Listed Leader')
            ->assertSee('Redacted')
            ->assertDontSee(self::LISTED_EMAIL)
            ->assertDontSee(self::LISTED_CELL);
    }

    #[Test]
    public function inactive_attachments_and_inactive_users_are_not_listed(): void
    {
        $inactiveAttachment = SystemUser::factory()->create(['first_name' => 'Retired', 'surname' => 'Scouter']);
        SystemUsersOtherRole::factory()->forUser($inactiveAttachment)->ofType($this->adultLeaderGroupRole)->inactive()->create(['groupID' => $this->group->id]);

        $inactiveUser = SystemUser::factory()->inactive()->create(['first_name' => 'Deactivated', 'surname' => 'Scouter']);
        SystemUsersOtherRole::factory()->forUser($inactiveUser)->ofType($this->adultLeaderGroupRole)->create(['groupID' => $this->group->id]);

        [$viewer, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/group-team")
            ->assertOk()
            ->assertDontSee('Retired Scouter')
            ->assertDontSee('Deactivated Scouter');
    }

    #[Test]
    public function group_team_defaults_to_the_viewers_group_and_lists_adult_leader_roles_only(): void
    {
        $this->listedGroupLeader();

        $otherGroup = Group::create(['name' => 'Other Group', 'groupTypeID' => 1, 'assoc_to_district' => $this->district->id, 'assoc_to_region' => $this->region->id, 'active' => 1, 'created' => now(), 'createdby' => 0]);
        $otherGroupLeader = SystemUser::factory()->create(['first_name' => 'Elsewhere', 'surname' => 'Leader']);
        SystemUsersOtherRole::factory()->forUser($otherGroupLeader)->ofType($this->adultLeaderGroupRole)->create(['groupID' => $otherGroup->id]);

        $parentInGroup = SystemUser::factory()->create(['first_name' => 'Ordinary', 'surname' => 'Parent']);
        SystemUsersOtherRole::factory()->forUser($parentInGroup)->ofType($this->parentRole)->create(['groupID' => $this->group->id]);

        $nonLeaderGroupRole = SystemUserType::factory()->group()->create(['name' => 'Group Volunteer', 'adultLeaderRole' => 0]);
        $volunteerInGroup = SystemUser::factory()->create(['first_name' => 'Helping', 'surname' => 'Volunteer']);
        SystemUsersOtherRole::factory()->forUser($volunteerInGroup)->ofType($nonLeaderGroupRole)->create(['groupID' => $this->group->id]);

        [$viewer, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/group-team")
            ->assertOk()
            ->assertSee('Listed Leader')
            ->assertDontSee('Elsewhere Leader')
            ->assertDontSee('Ordinary Parent')
            ->assertDontSee('Helping Volunteer');
    }

    #[Test]
    public function other_groups_can_be_browsed_through_the_group_filter(): void
    {
        $ownGroupLeader = $this->listedGroupLeader();

        $otherGroup = Group::create(['name' => 'Other Group', 'groupTypeID' => 1, 'assoc_to_district' => $this->district->id, 'assoc_to_region' => $this->region->id, 'active' => 1, 'created' => now(), 'createdby' => 0]);
        $otherGroupLeader = SystemUser::factory()->create(['first_name' => 'Elsewhere', 'surname' => 'Leader']);
        $otherGroupAttachment = SystemUsersOtherRole::factory()->forUser($otherGroupLeader)->ofType($this->adultLeaderGroupRole)->create(['groupID' => $otherGroup->id]);

        [$viewer, $tenant] = $this->viewerWithRole($this->parentRole);

        $this->actingAs($viewer);
        Filament::setCurrentPanel(Filament::getPanel('member'));
        Filament::setTenant($tenant);

        Livewire::test(GroupTeam::class)
            ->assertCanSeeTableRecords($ownGroupLeader->roleAttachments)
            ->assertCanNotSeeTableRecords([$otherGroupAttachment])
            ->filterTable('group', $otherGroup->id)
            ->assertCanSeeTableRecords([$otherGroupAttachment])
            ->assertCanNotSeeTableRecords($ownGroupLeader->roleAttachments)
            ->assertSee('Elsewhere Leader')
            ->assertDontSee(self::LISTED_EMAIL);
    }

    #[Test]
    public function national_team_lists_national_roles_for_every_member(): void
    {
        $nationalRole = SystemUserType::factory()->national()->create(['name' => 'National Awards Committee', 'adultLeaderRole' => 1]);
        $nationalMember = SystemUser::factory()->create(['first_name' => 'National', 'surname' => 'Officer']);
        SystemUsersOtherRole::factory()->forUser($nationalMember)->ofType($nationalRole)->create();

        $this->listedGroupLeader();

        [$viewer, $tenant] = $this->viewerWithRole($this->parentRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/national-team")
            ->assertOk()
            ->assertSee('National Officer')
            ->assertSee('National Awards Committee')
            ->assertDontSee('Listed Leader');
    }

    #[Test]
    public function regional_and_district_teams_default_to_the_viewers_area(): void
    {
        $regionalRole = SystemUserType::factory()->regional()->create(['name' => 'Regional Commissioner', 'adultLeaderRole' => 1]);
        $regionalMember = SystemUser::factory()->create(['first_name' => 'Regional', 'surname' => 'Officer']);
        SystemUsersOtherRole::factory()->forUser($regionalMember)->ofType($regionalRole)->create(['regionID' => $this->region->id]);

        $otherRegion = Region::create(['name' => 'Other Region', 'description' => '', 'phys_address' => '', 'countryID' => 196, 'active' => 1]);
        $otherRegionalMember = SystemUser::factory()->create(['first_name' => 'Faraway', 'surname' => 'Officer']);
        SystemUsersOtherRole::factory()->forUser($otherRegionalMember)->ofType($regionalRole)->create(['regionID' => $otherRegion->id]);

        $districtRole = SystemUserType::factory()->district()->create(['name' => 'District Commissioner', 'adultLeaderRole' => 1]);
        $districtMember = SystemUser::factory()->create(['first_name' => 'District', 'surname' => 'Officer']);
        SystemUsersOtherRole::factory()->forUser($districtMember)->ofType($districtRole)->create(['districtID' => $this->district->id]);

        [$viewer, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/regional-team")
            ->assertOk()
            ->assertSee('Regional Officer')
            ->assertDontSee('Faraway Officer');

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/district-team")
            ->assertOk()
            ->assertSee('District Officer');
    }

    #[Test]
    public function national_office_holders_never_show_a_cell_number(): void
    {
        $chiefScoutRole = SystemUserType::factory()->national()->create(['id' => 219, 'name' => 'Chief Scout', 'adultLeaderRole' => 1]);
        $chiefScout = SystemUser::factory()->create(['first_name' => 'Chief', 'surname' => 'Scout', 'username' => 'chief@directory.test', 'cellNr' => '0839876543']);
        SystemUsersOtherRole::factory()->forUser($chiefScout)->ofType($chiefScoutRole)->create();

        [$viewer, $tenant] = $this->viewerWithRole($this->adultLeaderGroupRole);

        $this->actingAs($viewer)
            ->get("/member/{$tenant->id}/directory/national-team")
            ->assertOk()
            ->assertSee('Chief Scout')
            ->assertSee('chief@directory.test')
            ->assertDontSee('0839876543');
    }

    /**
     * @param  array<string, mixed>  $userAttributes
     */
    private function listedGroupLeader(array $userAttributes = []): SystemUser
    {
        $leader = SystemUser::factory()->create([
            'first_name' => 'Listed',
            'surname' => 'Leader',
            'username' => self::LISTED_EMAIL,
            'cellNr' => self::LISTED_CELL,
            ...$userAttributes,
        ]);

        SystemUsersOtherRole::factory()
            ->forUser($leader)
            ->ofType($this->adultLeaderGroupRole)
            ->create(['groupID' => $this->group->id]);

        return $leader;
    }

    /**
     * @return array{SystemUser, SystemUsersOtherRole}
     */
    private function viewerWithRole(SystemUserType $roleType): array
    {
        $viewer = SystemUser::factory()->create(['first_name' => 'Viewing', 'surname' => 'Member']);

        $tenant = SystemUsersOtherRole::factory()
            ->forUser($viewer)
            ->ofType($roleType)
            ->create(['groupID' => $this->group->id, 'districtID' => $this->district->id, 'regionID' => $this->region->id]);

        return [$viewer, $tenant];
    }
}
