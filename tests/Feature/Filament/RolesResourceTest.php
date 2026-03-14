<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Models\SystemUser;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class RolesResourceTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    #[Test]
    public function super_admin_can_access_roles_list(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(RoleResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_view_a_role(): void
    {
        $role = SystemUserType::factory()->create();

        $this->actingAs($this->superAdmin)
            ->get(RoleResource::getUrl('view', ['record' => $role]))
            ->assertOk();
    }

    #[Test]
    public function regular_user_is_forbidden_from_roles_list(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(RoleResource::getUrl('index'))
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_from_roles_resource(): void
    {
        $this->get(RoleResource::getUrl('index'))
            ->assertRedirect();
    }
}
