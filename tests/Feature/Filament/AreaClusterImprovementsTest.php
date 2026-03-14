<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\Area\Resources\Districts\DistrictResource;
use App\Filament\Admin\Clusters\Area\Resources\Groups\GroupResource;
use App\Filament\Admin\Clusters\Area\Resources\Regions\RegionResource;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AreaClusterImprovementsTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    // --- Region ---

    #[Test]
    public function super_admin_can_list_regions(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(RegionResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_access_create_region_page(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(RegionResource::getUrl('create'))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_view_a_region(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);

        $this->actingAs($this->superAdmin)
            ->get(RegionResource::getUrl('view', ['record' => $region]))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_access_edit_region_page(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);

        $this->actingAs($this->superAdmin)
            ->get(RegionResource::getUrl('edit', ['record' => $region]))
            ->assertOk();
    }

    #[Test]
    public function regular_user_is_forbidden_from_regions(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(RegionResource::getUrl('index'))
            ->assertForbidden();
    }

    // --- District ---

    #[Test]
    public function super_admin_can_list_districts(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(DistrictResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_access_create_district_page(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(DistrictResource::getUrl('create'))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_view_a_district(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $district = District::create(['name' => 'Test District', 'regionID' => $region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);

        $this->actingAs($this->superAdmin)
            ->get(DistrictResource::getUrl('view', ['record' => $district]))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_access_edit_district_page(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $district = District::create(['name' => 'Test District', 'regionID' => $region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);

        $this->actingAs($this->superAdmin)
            ->get(DistrictResource::getUrl('edit', ['record' => $district]))
            ->assertOk();
    }

    #[Test]
    public function regular_user_is_forbidden_from_districts(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(DistrictResource::getUrl('index'))
            ->assertForbidden();
    }

    // --- Group ---

    #[Test]
    public function super_admin_can_list_groups(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(GroupResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_access_create_group_page(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(GroupResource::getUrl('create'))
            ->assertOk();
    }

    #[Test]
    public function regular_user_is_forbidden_from_groups(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(GroupResource::getUrl('index'))
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_area_resources(): void
    {
        $this->get(RegionResource::getUrl('index'))
            ->assertRedirect();
    }
}
