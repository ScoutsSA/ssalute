<?php

namespace Tests\Feature\Filament;

use App\Models\SystemUser;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use Filament\Facades\Filament;
use Filament\Support\Enums\Width;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AdminPanelTest extends SdCoreTestCase
{
    #[Test]
    public function backoffice_panel_uses_full_content_width(): void
    {
        $this->assertSame(Width::Full, Filament::getPanel('admin')->getMaxContentWidth());
    }

    #[Test]
    public function guest_is_redirected_to_login_when_accessing_admin_panel(): void
    {
        $this->get('/backoffice')
            ->assertRedirect('/login');
    }

    #[Test]
    public function regular_user_is_forbidden_from_accessing_admin_panel(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get('/backoffice')
            ->assertForbidden();
    }

    #[Test]
    public function super_admin_by_settings_list_can_access_admin_panel(): void
    {
        $user = SystemUser::factory()->create();

        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$user->id]])->save();

        $this->actingAs($user)
            ->get('/backoffice')
            ->assertOk();
    }

    #[Test]
    public function super_admin_by_config_username_can_access_admin_panel(): void
    {
        $user = SystemUser::factory()->create([
            'username' => 'superadmin@example.com',
        ]);

        config(['ssalute.superuser_email' => 'superadmin@example.com']);

        $this->actingAs($user)
            ->get('/backoffice')
            ->assertOk();
    }

    #[Test]
    public function district_level_user_cannot_access_admin_panel(): void
    {
        $districtRole = SystemUserType::factory()->district()->create();
        $user = SystemUser::factory()->withRole($districtRole)->create();

        $this->actingAs($user)
            ->get('/backoffice')
            ->assertForbidden();
    }
}
