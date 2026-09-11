<?php

namespace Tests\Feature\Services;

use App\Exceptions\AreaStillReferencedException;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Providers\AppServiceProvider;
use App\Services\Areas\AreaDeletionGuard;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AreaDeletionGuardTest extends SdCoreTestCase
{
    private AreaDeletionGuard $guard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->guard = resolve(AreaDeletionGuard::class);
    }

    #[Test]
    public function an_unreferenced_area_has_no_blockers_and_can_be_deleted(): void
    {
        $group = Group::factory()->create();
        $district = $group->district;
        $region = $group->region;

        $this->assertSame([], $this->guard->blockersFor($group));
        $this->assertTrue($this->guard->isDeletable($group));

        $group->delete();
        $district->delete();
        $region->delete();

        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
        $this->assertDatabaseMissing('districts', ['id' => $district->id]);
        $this->assertDatabaseMissing('regions', ['id' => $region->id]);
    }

    #[Test]
    public function a_region_is_blocked_by_its_districts_groups_roles_and_users(): void
    {
        $region = Region::factory()->create();
        District::factory()->count(2)->forRegion($region)->create();
        Group::factory()->forRegion($region)->create();
        SystemUsersOtherRole::factory()->create(['regionID' => $region->id]);
        SystemUser::factory()->count(3)->create(['assoc_to_region' => $region->id]);

        $blockers = $this->guard->blockersFor($region);

        $this->assertSame(3, $blockers['districts'], 'Two explicit districts plus the one the group factory creates.');
        $this->assertSame(1, $blockers['groups']);
        $this->assertSame(1, $blockers['system_users_other_roles']);
        $this->assertSame(3, $blockers['system_users']);
    }

    #[Test]
    public function a_region_is_blocked_by_a_row_in_a_table_without_a_model(): void
    {
        $region = Region::factory()->create();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('commerce_search_queries')->insert([
            'countryID' => 196,
            'regionID' => $region->id,
            'districtID' => 0,
            'groupID' => 0,
            'date' => now()->toDateString(),
            'time' => '10:00',
        ]);

        $this->assertSame(['commerce_search_queries' => 1], $this->guard->blockersFor($region));
    }

    #[Test]
    public function a_district_is_blocked_by_its_groups_roles_and_users(): void
    {
        $district = District::factory()->create();
        Group::factory()->forDistrict($district)->create();
        SystemUsersOtherRole::factory()->create(['districtID' => $district->id]);
        SystemUser::factory()->create(['assoc_to_district' => $district->id]);

        $blockers = $this->guard->blockersFor($district);

        $this->assertSame(1, $blockers['groups']);
        $this->assertSame(1, $blockers['system_users_other_roles']);
        $this->assertSame(1, $blockers['system_users']);
    }

    #[Test]
    public function a_group_is_blocked_by_roles_users_sections_and_any_other_referencing_row(): void
    {
        $group = Group::factory()->create();
        SystemUsersOtherRole::factory()->create(['groupID' => $group->id]);
        SystemUser::factory()->create(['assoc_to_group' => $group->id]);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_cub_packs')->insert([
            'assocToGroup' => $group->id,
            'name' => 'Test Pack',
            'created' => now(),
            'createdby' => 1,
        ]);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('commerce_search_queries')->insert([
            'countryID' => 196,
            'regionID' => 0,
            'districtID' => 0,
            'groupID' => $group->id,
            'date' => now()->toDateString(),
            'time' => '10:00',
        ]);

        $blockers = $this->guard->blockersFor($group);

        $this->assertSame(1, $blockers['system_users_other_roles']);
        $this->assertSame(1, $blockers['system_users']);
        $this->assertSame(1, $blockers['group_cub_packs']);
        $this->assertSame(1, $blockers['commerce_search_queries']);
    }

    #[Test]
    public function secondary_reference_columns_count_once_per_table(): void
    {
        $group = Group::factory()->create();

        SystemUsersOtherRole::factory()->create(['groupID' => 0, 'actionGroupID' => $group->id]);
        SystemUser::factory()->create(['roverGroupID' => $group->id]);

        $blockers = $this->guard->blockersFor($group);

        $this->assertSame(1, $blockers['system_users_other_roles']);
        $this->assertSame(1, $blockers['system_users']);
    }

    #[Test]
    public function deleting_a_referenced_area_throws_and_keeps_the_row(): void
    {
        $region = Region::factory()->create(['name' => 'Gauteng']);
        District::factory()->forRegion($region)->create();

        try {
            $region->delete();
            $this->fail('Expected AreaStillReferencedException.');
        } catch (AreaStillReferencedException $exception) {
            $this->assertStringContainsString("Region Gauteng (#{$region->id}) cannot be deleted", $exception->getMessage());
            $this->assertStringContainsString('Districts: 1', $exception->getMessage());
        }

        $this->assertDatabaseHas('regions', ['id' => $region->id]);
    }

    #[Test]
    public function describe_lists_the_first_ten_tables_and_summarises_the_rest(): void
    {
        $blockers = [];

        for ($i = 1; $i <= 12; $i++) {
            $blockers["table_{$i}"] = $i;
        }

        $description = AreaDeletionGuard::describe($blockers);

        $this->assertStringStartsWith('Table 1: 1, Table 2: 2', $description);
        $this->assertStringEndsWith('Table 10: 10, and 2 more', $description);
    }

    #[Test]
    public function blockers_are_memoised_per_record_until_forgotten(): void
    {
        $region = Region::factory()->create();

        $this->assertSame([], $this->guard->blockersFor($region));

        District::factory()->forRegion($region)->create();

        $this->assertSame([], $this->guard->blockersFor($region));

        $this->guard->forget($region);

        $this->assertSame(['districts' => 1], $this->guard->blockersFor($region));
    }
}
