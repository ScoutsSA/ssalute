<?php

namespace Tests\Feature\Filament\HoldingZone;

use App\Models\SystemUser;
use App\Models\SystemUserType;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class HoldingZonePanelTest extends SdCoreTestCase
{
    // ── Panel access ──

    #[Test]
    public function guest_is_redirected_to_holding_zone_login(): void
    {
        $this->get('/holding-zone')
            ->assertRedirect('/holding-zone/login');
    }

    #[Test]
    public function login_page_is_accessible(): void
    {
        $this->get('/holding-zone/login')->assertOk();
    }

    #[Test]
    public function login_page_offers_scouts_digital_login_only_when_the_hand_off_is_configured(): void
    {
        config()->set('ssalute.scouts_digital_url', 'https://sd.example.test/');
        config()->set('ssalute.scouts_digital_sso_secret', 'dGVzdC1zZWNyZXQ=');

        $this->get('/holding-zone/login')
            ->assertOk()
            ->assertSee('Log in via Scouts.Digital')
            ->assertSee('https://sd.example.test/sso-handoff.php?app=ssalute');

        config()->set('ssalute.scouts_digital_sso_secret', '');

        $this->get('/holding-zone/login')
            ->assertOk()
            ->assertDontSee('Log in via Scouts.Digital');
    }

    #[Test]
    public function root_login_redirects_to_holding_zone_login(): void
    {
        $this->get('/login')
            ->assertRedirect('/holding-zone/login');
    }

    #[Test]
    public function user_without_roles_can_access_holding_zone_dashboard(): void
    {
        $user = SystemUser::factory()->create();

        $this->actingAs($user)
            ->get('/holding-zone')
            ->assertOk();
    }

    #[Test]
    public function user_with_roles_can_access_holding_zone(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get('/holding-zone')
            ->assertOk();
    }

    #[Test]
    public function user_with_only_unwarranted_roles_can_access_holding_zone(): void
    {
        $warrantedType = SystemUserType::factory()->group()->warranted()->create();
        $user = SystemUser::factory()->withRole($warrantedType)->create();

        $this->actingAs($user)
            ->get('/holding-zone')
            ->assertOk();
    }

    // ── Unified login redirects ──

    #[Test]
    public function unauthenticated_member_panel_access_redirects_to_unified_login(): void
    {
        $this->get('/member/123/dashboard')
            ->assertRedirect('/login');
    }

    #[Test]
    public function unauthenticated_admin_panel_access_redirects_to_unified_login(): void
    {
        $this->get('/backoffice')
            ->assertRedirect('/login');
    }

    // ── Welcome page links ──

    #[Test]
    public function welcome_page_links_to_holding_zone_for_unauthenticated_users(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('/holding-zone/login');
    }

    #[Test]
    public function welcome_page_links_to_member_panel_for_user_with_tenants(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertSee("/member/{$tenant->id}/dashboard");
    }

    #[Test]
    public function welcome_page_links_to_holding_zone_for_user_without_tenants(): void
    {
        $user = SystemUser::factory()->create();

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertSee('/holding-zone');
    }
}
