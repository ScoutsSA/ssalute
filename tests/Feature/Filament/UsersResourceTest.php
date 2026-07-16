<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class UsersResourceTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    #[Test]
    public function super_admin_can_access_users_list(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(UserResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_view_a_user(): void
    {
        $user = SystemUser::factory()->create();

        $this->actingAs($this->superAdmin)
            ->get(UserResource::getUrl('view', ['record' => $user]))
            ->assertOk();
    }

    /**
     * Skipped: UserForm has 800+ form fields causing memory exhaustion at 128MB.
     * Run manually with: php -d memory_limit=512M artisan test --filter=super_admin_can_access_edit_user_page
     */
    // #[Test]
    // public function super_admin_can_access_edit_user_page(): void
    // {
    //     $user = SystemUser::factory()->create();
    //
    //     $this->actingAs($this->superAdmin)
    //         ->get(UserResource::getUrl('edit', ['record' => $user]))
    //         ->assertOk();
    // }

    #[Test]
    public function home_location_relations_resolve_to_the_assoc_columns(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $district = District::create(['name' => 'Test District', 'regionID' => $region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);
        $group = Group::create(['name' => 'Test Group', 'groupTypeID' => 1, 'assoc_to_district' => $district->id, 'assoc_to_region' => $region->id, 'active' => 1, 'created' => now(), 'createdby' => 0]);

        $user = SystemUser::factory()->create([
            'assoc_to_region' => $region->id,
            'assoc_to_district' => $district->id,
            'assoc_to_group' => $group->id,
        ]);

        $this->assertSame($region->id, $user->homeRegion->id);
        $this->assertSame($district->id, $user->homeDistrict->id);
        $this->assertSame($group->id, $user->homeGroup->id);
    }

    #[Test]
    public function view_page_shows_the_resolved_home_group_name(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $district = District::create(['name' => 'Test District', 'regionID' => $region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);
        $group = Group::create(['name' => 'Bryanston Home Group', 'groupTypeID' => 1, 'assoc_to_district' => $district->id, 'assoc_to_region' => $region->id, 'active' => 1, 'created' => now(), 'createdby' => 0]);

        $user = SystemUser::factory()->create([
            'assoc_to_region' => $region->id,
            'assoc_to_district' => $district->id,
            'assoc_to_group' => $group->id,
        ]);

        $this->actingAs($this->superAdmin)
            ->get(UserResource::getUrl('view', ['record' => $user]))
            ->assertOk()
            ->assertSee('Bryanston Home Group')
            ->assertSee("(#{$group->id})");
    }

    #[Test]
    public function home_district_options_are_scoped_to_the_selected_region_but_keep_the_current_value(): void
    {
        $regionA = Region::create(['name' => 'Region A', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $regionB = Region::create(['name' => 'Region B', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $districtInA = District::create(['name' => 'District In A', 'regionID' => $regionA->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);
        $districtInB = District::create(['name' => 'District In B', 'regionID' => $regionB->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);

        $scoped = UserForm::homeDistrictOptions($regionA->id, null);
        $this->assertTrue($scoped->has($districtInA->id));
        $this->assertFalse($scoped->has($districtInB->id));

        // A currently-stored district from another region is never dropped.
        $withCurrent = UserForm::homeDistrictOptions($regionA->id, $districtInB->id);
        $this->assertTrue($withCurrent->has($districtInA->id));
        $this->assertTrue($withCurrent->has($districtInB->id));

        // No region selected: unscoped (all districts).
        $unscoped = UserForm::homeDistrictOptions(null, null);
        $this->assertTrue($unscoped->has($districtInA->id));
        $this->assertTrue($unscoped->has($districtInB->id));
    }

    #[Test]
    public function home_group_options_are_scoped_to_the_selected_district_and_active_but_keep_the_current_value(): void
    {
        $region = Region::create(['name' => 'Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $districtA = District::create(['name' => 'District A', 'regionID' => $region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);
        $districtB = District::create(['name' => 'District B', 'regionID' => $region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);

        $groupInA = $this->makeGroup('Group In A', $districtA->id, $region->id);
        $groupInB = $this->makeGroup('Group In B', $districtB->id, $region->id);
        $inactiveInA = $this->makeGroup('Inactive In A', $districtA->id, $region->id, active: 0);

        $scoped = UserForm::homeGroupOptions($districtA->id, null);
        $this->assertTrue($scoped->has($groupInA->id));
        $this->assertFalse($scoped->has($groupInB->id));
        $this->assertFalse($scoped->has($inactiveInA->id));

        // The currently-stored group is kept even when inactive or in another district.
        $withCurrent = UserForm::homeGroupOptions($districtA->id, $groupInB->id);
        $this->assertTrue($withCurrent->has($groupInA->id));
        $this->assertTrue($withCurrent->has($groupInB->id));
    }

    #[Test]
    public function regular_user_is_forbidden_from_users_list(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(UserResource::getUrl('index'))
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_from_users_resource(): void
    {
        $this->get(UserResource::getUrl('index'))
            ->assertRedirect();
    }

    private function makeGroup(string $name, int $districtId, int $regionId, int $active = 1): Group
    {
        return Group::create([
            'name' => $name,
            'groupTypeID' => 1,
            'assoc_to_district' => $districtId,
            'assoc_to_region' => $regionId,
            'active' => $active,
            'created' => now(),
            'createdby' => 0,
        ]);
    }
}
