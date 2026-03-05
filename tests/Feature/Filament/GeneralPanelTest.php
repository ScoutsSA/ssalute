<?php

namespace Tests\Feature\Filament;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class GeneralPanelTest extends SdCoreTestCase
{
    #[Test]
    public function guest_is_redirected_to_login_when_accessing_general_panel(): void
    {
        $this->get('/general')
            ->assertRedirect('/general/login');
    }

    #[Test]
    public function login_page_is_accessible(): void
    {
        $this->get('/general/login')->assertOk();
    }

    #[Test]
    public function authenticated_user_visiting_general_is_redirected_to_their_tenant_home(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get('/general')
            ->assertRedirect("/general/{$tenant->id}");
    }

    #[Test]
    public function authenticated_user_visiting_tenant_home_is_redirected_to_dashboard(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}")
            ->assertRedirect("/general/{$tenant->id}/dashboard");
    }

    #[Test]
    public function user_with_no_roles_is_denied_access_to_general_panel(): void
    {
        $user = SystemUser::factory()->create();

        $this->actingAs($user)
            ->get('/general')
            ->assertForbidden();
    }

    #[Test]
    public function user_with_an_active_role_can_access_their_dashboard(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $roleAttachment = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$roleAttachment->id}/dashboard")
            ->assertOk();
    }

    #[Test]
    public function user_accessing_general_panel_root_is_redirected_to_their_tenant_dashboard(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $roleAttachment = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get('/general')
            ->assertRedirect("/general/{$roleAttachment->id}");
    }

    #[Test]
    public function user_with_shared_link_to_another_users_tenant_is_redirected_to_their_own(): void
    {
        $roleType = SystemUserType::factory()->group()->create();

        $userA = SystemUser::factory()->withRole($roleType)->create();
        $userB = SystemUser::factory()->withRole($roleType)->create();

        $userATenant = $userA->roleAttachments()->first();
        $userBTenant = $userB->roleAttachments()->first();

        // User B tries to access User A's tenant URL
        $this->actingAs($userB)
            ->get("/general/{$userATenant->id}")
            ->assertRedirect("/general/{$userBTenant->id}");
    }

    #[Test]
    public function user_with_multiple_roles_can_switch_between_their_tenants(): void
    {
        $roleType = SystemUserType::factory()->group()->create();
        $user = SystemUser::factory()->create();

        $firstRole = SystemUsersOtherRole::factory()->forUser($user)->ofType($roleType)->create();
        $secondRole = SystemUsersOtherRole::factory()->forUser($user)->ofType($roleType)->create();

        $this->actingAs($user)
            ->get("/general/{$firstRole->id}/dashboard")
            ->assertOk();

        $this->actingAs($user)
            ->get("/general/{$secondRole->id}/dashboard")
            ->assertOk();
    }

    #[Test]
    public function inactive_role_does_not_grant_access_to_that_tenant(): void
    {
        $roleType = SystemUserType::factory()->create();
        $user = SystemUser::factory()->create();

        $inactiveRole = SystemUsersOtherRole::factory()
            ->forUser($user)
            ->ofType($roleType)
            ->inactive()
            ->create();

        // No active roles — user should be denied panel access entirely
        $this->actingAs($user)
            ->get("/general/{$inactiveRole->id}")
            ->assertForbidden();
    }

    #[Test]
    public function user_with_only_inactive_roles_cannot_access_general_panel(): void
    {
        $roleType = SystemUserType::factory()->create();
        $user = SystemUser::factory()->create();

        SystemUsersOtherRole::factory()
            ->forUser($user)
            ->ofType($roleType)
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get('/general')
            ->assertForbidden();
    }

    #[Test]
    public function switching_tenants_always_lands_on_the_dashboard(): void
    {
        $roleType = SystemUserType::factory()->group()->create();
        $user = SystemUser::factory()->create();

        $roleA = SystemUsersOtherRole::factory()->forUser($user)->ofType($roleType)->create();
        $roleB = SystemUsersOtherRole::factory()->forUser($user)->ofType($roleType)->create();

        $this->actingAs($user)
            ->get("/general/{$roleA->id}/dashboard")
            ->assertOk();

        $this->actingAs($user)
            ->get("/general/{$roleB->id}/dashboard")
            ->assertOk();
    }
}
