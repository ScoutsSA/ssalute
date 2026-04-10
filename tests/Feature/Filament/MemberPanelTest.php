<?php

namespace Tests\Feature\Filament;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class MemberPanelTest extends SdCoreTestCase
{
    #[Test]
    public function guest_is_redirected_to_unified_login(): void
    {
        $this->get('/member')
            ->assertRedirect('/login');
    }

    #[Test]
    public function guest_accessing_tenant_url_is_redirected_to_unified_login(): void
    {
        $this->get('/member/123/dashboard')
            ->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_is_redirected_to_their_tenant(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get('/member')
            ->assertRedirect("/member/{$tenant->id}");
    }

    #[Test]
    public function authenticated_user_visiting_tenant_home_is_redirected_to_dashboard(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}")
            ->assertRedirect("/member/{$tenant->id}/dashboard");
    }

    #[Test]
    public function user_with_no_roles_is_denied_access(): void
    {
        $user = SystemUser::factory()->create();

        $this->actingAs($user)
            ->get('/member')
            ->assertForbidden();
    }

    #[Test]
    public function user_with_active_role_can_access_dashboard(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertOk();
    }

    #[Test]
    public function user_cannot_access_another_users_tenant(): void
    {
        $roleType = SystemUserType::factory()->group()->create();

        $userA = SystemUser::factory()->withRole($roleType)->create();
        $userB = SystemUser::factory()->withRole($roleType)->create();

        $userATenant = $userA->roleAttachments()->first();
        $userBTenant = $userB->roleAttachments()->first();

        $this->actingAs($userB)
            ->get("/member/{$userATenant->id}")
            ->assertRedirect("/member/{$userBTenant->id}");
    }

    #[Test]
    public function user_with_multiple_roles_can_switch_tenants(): void
    {
        $roleType = SystemUserType::factory()->group()->create();
        $user = SystemUser::factory()->create();

        $firstRole = SystemUsersOtherRole::factory()->forUser($user)->ofType($roleType)->create();
        $secondRole = SystemUsersOtherRole::factory()->forUser($user)->ofType($roleType)->create();

        $this->actingAs($user)
            ->get("/member/{$firstRole->id}/dashboard")
            ->assertOk();

        $this->actingAs($user)
            ->get("/member/{$secondRole->id}/dashboard")
            ->assertOk();
    }

    #[Test]
    public function inactive_role_does_not_grant_tenant_access(): void
    {
        $user = SystemUser::factory()->create();

        $inactiveRole = SystemUsersOtherRole::factory()
            ->forUser($user)
            ->ofType(SystemUserType::factory()->create())
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get("/member/{$inactiveRole->id}")
            ->assertForbidden();
    }

    #[Test]
    public function user_with_only_inactive_roles_is_denied_access(): void
    {
        $user = SystemUser::factory()->create();

        SystemUsersOtherRole::factory()
            ->forUser($user)
            ->ofType(SystemUserType::factory()->create())
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get('/member')
            ->assertForbidden();
    }
}
