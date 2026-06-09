<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\Settings\Pages\ManageDataFixesSettings;
use App\Filament\Admin\Clusters\Settings\Pages\ManageFormSettings;
use App\Filament\Admin\Clusters\Settings\Pages\ManageGeneralSettings;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class SettingsPagesTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    #[Test]
    public function super_admin_can_access_general_settings(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(ManageGeneralSettings::getUrl())
            ->assertOk();
    }

    #[Test]
    public function super_admin_can_access_form_settings(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(ManageFormSettings::getUrl())
            ->assertOk();
    }

    #[Test]
    public function regular_user_is_forbidden_from_general_settings(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(ManageGeneralSettings::getUrl())
            ->assertForbidden();
    }

    #[Test]
    public function regular_user_is_forbidden_from_form_settings(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(ManageFormSettings::getUrl())
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_from_settings(): void
    {
        $this->get(ManageGeneralSettings::getUrl())
            ->assertRedirect();
    }

    #[Test]
    public function super_admin_can_access_data_fixes_settings(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(ManageDataFixesSettings::getUrl())
            ->assertOk();
    }

    #[Test]
    public function regular_user_is_forbidden_from_data_fixes_settings(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get(ManageDataFixesSettings::getUrl())
            ->assertForbidden();
    }
}
