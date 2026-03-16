<?php

namespace Tests\Feature\Filament\General;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Settings\FeatureSettings;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AreaResourcesTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $features = resolve(FeatureSettings::class);
        $features->users_can_browse_areas = true;
        $features->save();
    }

    #[Test]
    public function guest_cannot_access_regions_list(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->get("/general/{$tenant->id}/area/regions")
            ->assertRedirect('/general/login');
    }

    #[Test]
    public function authenticated_user_can_access_regions_list(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/regions")
            ->assertOk();
    }

    #[Test]
    public function authenticated_user_can_view_a_region(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();
        $region = Region::first();

        if (! $region) {
            $this->markTestSkipped('No regions in database');
        }

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/regions/{$region->id}")
            ->assertOk();
    }

    #[Test]
    public function authenticated_user_can_access_districts_list(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/districts")
            ->assertOk();
    }

    #[Test]
    public function authenticated_user_can_view_a_district(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();
        $district = District::first();

        if (! $district) {
            $this->markTestSkipped('No districts in database');
        }

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/districts/{$district->id}")
            ->assertOk();
    }

    #[Test]
    public function authenticated_user_can_access_groups_list(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/groups")
            ->assertOk();
    }

    #[Test]
    public function authenticated_user_can_view_a_group(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();
        $group = Group::first();

        if (! $group) {
            $this->markTestSkipped('No groups in database');
        }

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/groups/{$group->id}")
            ->assertOk();
    }

    #[Test]
    public function create_route_does_not_exist_for_regions(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/regions/create")
            ->assertNotFound();
    }

    #[Test]
    public function create_route_does_not_exist_for_districts(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/districts/create")
            ->assertNotFound();
    }

    #[Test]
    public function create_route_does_not_exist_for_groups(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/area/groups/create")
            ->assertNotFound();
    }
}
