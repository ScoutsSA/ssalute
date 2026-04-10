<?php

namespace Tests\Feature\Filament\Member;

use App\Models\AmsWarrantInfo;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use Filament\Facades\Filament;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class WarrantAccessTest extends SdCoreTestCase
{
    #[Test]
    public function role_without_warrant_requirement_is_accessible(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertOk();
    }

    #[Test]
    public function warranted_role_with_active_warrant_is_accessible(): void
    {
        $roleType = SystemUserType::factory()->group()->warranted()->create();
        $user = SystemUser::factory()->withRole($roleType)->create();
        $tenant = $user->roleAttachments()->first();

        AmsWarrantInfo::factory()->forRoleAttachment($tenant)->create();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertOk();
    }

    #[Test]
    public function warranted_role_without_warrant_is_denied_access(): void
    {
        $roleType = SystemUserType::factory()->group()->warranted()->create();
        $user = SystemUser::factory()->withRole($roleType)->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertForbidden();
    }

    #[Test]
    public function appointment_role_with_active_appointment_is_accessible(): void
    {
        $roleType = SystemUserType::factory()->group()->appointment()->create();
        $user = SystemUser::factory()->withRole($roleType)->create();
        $tenant = $user->roleAttachments()->first();

        AmsWarrantInfo::factory()->forRoleAttachment($tenant)->create();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertOk();
    }

    #[Test]
    public function appointment_role_without_appointment_is_denied_access(): void
    {
        $roleType = SystemUserType::factory()->group()->appointment()->create();
        $user = SystemUser::factory()->withRole($roleType)->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertForbidden();
    }

    #[Test]
    public function warranted_role_with_inactive_warrant_is_denied_access(): void
    {
        $roleType = SystemUserType::factory()->group()->warranted()->create();
        $user = SystemUser::factory()->withRole($roleType)->create();
        $tenant = $user->roleAttachments()->first();

        AmsWarrantInfo::factory()->forRoleAttachment($tenant)->inactive()->create();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertForbidden();
    }

    #[Test]
    public function tenant_list_excludes_roles_without_valid_warrant(): void
    {
        $warrantedType = SystemUserType::factory()->group()->warranted()->create();
        $normalType = SystemUserType::factory()->group()->create();
        $user = SystemUser::factory()->create();

        $warrantedRole = SystemUsersOtherRole::factory()->forUser($user)->ofType($warrantedType)->create();
        $normalRole = SystemUsersOtherRole::factory()->forUser($user)->ofType($normalType)->create();

        $panel = Filament::getPanel('member');
        $tenants = $user->getTenants($panel);

        $this->assertCount(1, $tenants);
        $this->assertEquals($normalRole->id, $tenants->first()->id);
    }

    #[Test]
    public function tenant_list_includes_warranted_role_with_valid_warrant(): void
    {
        $warrantedType = SystemUserType::factory()->group()->warranted()->create();
        $user = SystemUser::factory()->create();

        $warrantedRole = SystemUsersOtherRole::factory()->forUser($user)->ofType($warrantedType)->create();
        AmsWarrantInfo::factory()->forRoleAttachment($warrantedRole)->create();

        $panel = Filament::getPanel('member');
        $tenants = $user->getTenants($panel);

        $this->assertCount(1, $tenants);
        $this->assertEquals($warrantedRole->id, $tenants->first()->id);
    }
}
