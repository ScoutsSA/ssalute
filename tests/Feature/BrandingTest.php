<?php

namespace Tests\Feature;

use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

/**
 * The SCOUTS South Africa corporate brand on official surfaces (ticket 034):
 * the supplied logo artwork, the WOSM membership line and the organisation
 * name written in full. Assertions are on alt text and copy, not markup.
 */
class BrandingTest extends SdCoreTestCase
{
    private const string LOGO_ALT = 'alt="SCOUTS South Africa"';

    private const string MEMBERSHIP_LINE = 'Member of the World Organisation of the Scout Movement';

    #[Test]
    public function splash_page_carries_the_ssa_logo_and_membership_line(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(self::LOGO_ALT, false)
            ->assertSee('images/brand/ssa-logo-white-on-purple.svg')
            ->assertSee(self::MEMBERSHIP_LINE)
            ->assertSee('SCOUTS South Africa')
            ->assertDontSee('Scouts SA');
    }

    #[Test]
    public function holding_zone_login_carries_the_ssa_logo_and_membership_line(): void
    {
        $this->get('/holding-zone/login')
            ->assertOk()
            ->assertSee(self::LOGO_ALT, false)
            ->assertSee('Sign in to Ssalute')
            ->assertSee(self::MEMBERSHIP_LINE);
    }

    #[Test]
    public function password_reset_request_page_carries_the_ssa_logo_and_membership_line(): void
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee(self::LOGO_ALT, false)
            ->assertSee(self::MEMBERSHIP_LINE);
    }

    #[Test]
    public function member_panel_carries_the_ssa_logo_and_membership_line(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/member/{$tenant->id}/dashboard")
            ->assertOk()
            ->assertSee(self::LOGO_ALT, false)
            ->assertSee(self::MEMBERSHIP_LINE);
    }

    #[Test]
    public function holding_zone_panel_carries_the_ssa_logo_and_membership_line(): void
    {
        $user = SystemUser::factory()->create();

        $this->actingAs($user)
            ->get('/holding-zone')
            ->assertOk()
            ->assertSee(self::LOGO_ALT, false)
            ->assertSee(self::MEMBERSHIP_LINE);
    }

    #[Test]
    public function backoffice_panel_carries_the_ssa_logo_and_membership_line(): void
    {
        $superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$superAdmin->id]])->save();
        Cache::flush();

        $this->actingAs($superAdmin)
            ->get('/backoffice')
            ->assertOk()
            ->assertSee(self::LOGO_ALT, false)
            ->assertSee('BackOffice')
            ->assertSee(self::MEMBERSHIP_LINE);
    }

    #[Test]
    public function the_logo_component_renders_the_supplied_artwork_unaltered(): void
    {
        $onPurple = view('components.ssa.logo', ['variant' => 'on-purple', 'attributes' => new \Illuminate\View\ComponentAttributeBag])->render();
        $onWhite = view('components.ssa.logo', ['variant' => 'on-white', 'attributes' => new \Illuminate\View\ComponentAttributeBag])->render();

        $this->assertStringContainsString('images/brand/ssa-logo-white-on-purple.svg', $onPurple);
        $this->assertStringContainsString('images/brand/ssa-logo-purple-on-white.svg', $onWhite);
        $this->assertStringContainsString(self::LOGO_ALT, $onPurple);
        $this->assertStringContainsString('min-w-[120px]', $onPurple);

        foreach (['ssa-logo-white-on-purple', 'ssa-logo-purple-on-white', 'ssa-rope-flag-be-prepared'] as $file) {
            $this->assertFileExists(public_path("images/brand/{$file}.svg"));
            $this->assertFileExists(public_path("images/brand/{$file}.png"));
        }
    }
}
