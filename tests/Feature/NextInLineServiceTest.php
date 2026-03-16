<?php

namespace Tests\Feature;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Services\NextInLineService;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class NextInLineServiceTest extends SdCoreTestCase
{
    private GeneralSettings $settings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->settings = resolve(GeneralSettings::class);
    }

    #[Test]
    public function it_resolves_next_in_line_at_group_level(): void
    {
        $groupNextInLineType = SystemUserType::factory()->group()->create();
        $this->settings->next_in_line_role_group = $groupNextInLineType->id;
        $this->settings->save();

        $scouter = SystemUser::factory()->create();
        $scouterRole = SystemUsersOtherRole::factory()
            ->forUser($scouter)
            ->ofType($groupNextInLineType)
            ->create(['groupID' => 10]);

        $reporterType = SystemUserType::factory()->group()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterType->id, 'groupID' => 10]);

        $service = new NextInLineService($this->settings);
        $result = $service->resolve($reporterRole);

        $this->assertNotNull($result);
        $this->assertEquals($scouter->id, $result->id);
        $this->assertTrue($result->relationLoaded('relevantRole'));
        $this->assertEquals($scouterRole->id, $result->relevantRole->id);
    }

    #[Test]
    public function it_escalates_from_group_to_district_when_no_group_match(): void
    {
        $districtNextInLineType = SystemUserType::factory()->district()->create();
        $this->settings->next_in_line_role_group = null;
        $this->settings->next_in_line_role_district = $districtNextInLineType->id;
        $this->settings->save();

        $scouter = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($scouter)
            ->ofType($districtNextInLineType)
            ->create(['districtID' => 5]);

        $reporterType = SystemUserType::factory()->group()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterType->id, 'groupID' => 10, 'districtID' => 5]);

        $service = new NextInLineService($this->settings);
        $result = $service->resolve($reporterRole);

        $this->assertNotNull($result);
        $this->assertEquals($scouter->id, $result->id);
    }

    #[Test]
    public function national_role_holder_skips_to_national_level(): void
    {
        $groupNextInLineType = SystemUserType::factory()->group()->create();
        $nationalNextInLineType = SystemUserType::factory()->national()->create();

        $this->settings->next_in_line_role_group = $groupNextInLineType->id;
        $this->settings->next_in_line_role_national = $nationalNextInLineType->id;
        $this->settings->save();

        // Group-level scouter that should NOT be matched
        $groupScouter = SystemUser::factory()->create(['first_name' => 'GroupGuy']);
        SystemUsersOtherRole::factory()
            ->forUser($groupScouter)
            ->ofType($groupNextInLineType)
            ->create(['groupID' => 10]);

        // National-level scouter that SHOULD be matched
        $nationalScouter = SystemUser::factory()->create(['first_name' => 'NationalGal']);
        SystemUsersOtherRole::factory()
            ->forUser($nationalScouter)
            ->ofType($nationalNextInLineType)
            ->create();

        // Reporter holds a national role
        $reporterNationalType = SystemUserType::factory()->national()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterNationalType->id, 'groupID' => 10]);

        $service = new NextInLineService($this->settings);
        $result = $service->resolve($reporterRole);

        $this->assertNotNull($result);
        $this->assertEquals($nationalScouter->id, $result->id);
    }

    #[Test]
    public function regional_role_holder_starts_at_regional_level(): void
    {
        $groupNextInLineType = SystemUserType::factory()->group()->create();
        $regionalNextInLineType = SystemUserType::factory()->regional()->create();

        $this->settings->next_in_line_role_group = $groupNextInLineType->id;
        $this->settings->next_in_line_role_regional = $regionalNextInLineType->id;
        $this->settings->save();

        // Group-level scouter that should NOT be matched
        $groupScouter = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($groupScouter)
            ->ofType($groupNextInLineType)
            ->create(['groupID' => 10]);

        // Regional-level scouter that SHOULD be matched
        $regionalScouter = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($regionalScouter)
            ->ofType($regionalNextInLineType)
            ->create(['regionID' => 3]);

        $reporterRegionalType = SystemUserType::factory()->regional()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterRegionalType->id, 'regionID' => 3, 'groupID' => 10]);

        $service = new NextInLineService($this->settings);
        $result = $service->resolve($reporterRole);

        $this->assertNotNull($result);
        $this->assertEquals($regionalScouter->id, $result->id);
    }

    #[Test]
    public function it_returns_null_when_no_match_found(): void
    {
        $this->settings->next_in_line_role_group = null;
        $this->settings->next_in_line_role_district = null;
        $this->settings->next_in_line_role_regional = null;
        $this->settings->next_in_line_role_national = null;
        $this->settings->save();

        $reporterType = SystemUserType::factory()->group()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterType->id]);

        $service = new NextInLineService($this->settings);
        $result = $service->resolve($reporterRole);

        $this->assertNull($result);
    }

    #[Test]
    public function resolve_all_returns_collection_with_relevant_roles(): void
    {
        $groupNextInLineType = SystemUserType::factory()->group()->create();
        $this->settings->next_in_line_role_group = $groupNextInLineType->id;
        $this->settings->save();

        $scouter1 = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($scouter1)
            ->ofType($groupNextInLineType)
            ->create(['groupID' => 10]);

        $scouter2 = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($scouter2)
            ->ofType($groupNextInLineType)
            ->create(['groupID' => 10]);

        $reporterType = SystemUserType::factory()->group()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterType->id, 'groupID' => 10]);

        $service = new NextInLineService($this->settings);
        $results = $service->resolveAll($reporterRole);

        $this->assertCount(2, $results);
        $this->assertTrue($results->every(fn ($u) => $u->relationLoaded('relevantRole')));
    }

    #[Test]
    public function it_does_not_match_inactive_role_attachments(): void
    {
        $groupNextInLineType = SystemUserType::factory()->group()->create();
        $this->settings->next_in_line_role_group = $groupNextInLineType->id;
        $this->settings->save();

        $scouter = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($scouter)
            ->ofType($groupNextInLineType)
            ->inactive()
            ->create(['groupID' => 10]);

        $reporterType = SystemUserType::factory()->group()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterType->id, 'groupID' => 10]);

        $service = new NextInLineService($this->settings);
        $result = $service->resolve($reporterRole);

        $this->assertNull($result);
    }

    #[Test]
    public function it_scopes_by_geographic_area(): void
    {
        $groupNextInLineType = SystemUserType::factory()->group()->create();
        $this->settings->next_in_line_role_group = $groupNextInLineType->id;
        $this->settings->save();

        // Scouter in a different group — should NOT match
        $wrongGroupScouter = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($wrongGroupScouter)
            ->ofType($groupNextInLineType)
            ->create(['groupID' => 99]);

        // Scouter in the same group — SHOULD match
        $sameGroupScouter = SystemUser::factory()->create();
        SystemUsersOtherRole::factory()
            ->forUser($sameGroupScouter)
            ->ofType($groupNextInLineType)
            ->create(['groupID' => 10]);

        $reporterType = SystemUserType::factory()->group()->create();
        $reporterRole = SystemUsersOtherRole::factory()
            ->create(['roleID' => $reporterType->id, 'groupID' => 10]);

        $service = new NextInLineService($this->settings);
        $result = $service->resolve($reporterRole);

        $this->assertNotNull($result);
        $this->assertEquals($sameGroupScouter->id, $result->id);
    }
}
