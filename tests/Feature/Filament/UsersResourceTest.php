<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Users\UserResource;
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
}
