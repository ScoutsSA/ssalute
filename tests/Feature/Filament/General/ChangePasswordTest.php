<?php

namespace Tests\Feature\Filament\General;

use App\Filament\General\Pages\ChangePassword;
use App\Models\SystemUser;
use Filament\Facades\Filament;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class ChangePasswordTest extends SdCoreTestCase
{
    #[Test]
    public function guest_cannot_access_change_password_page(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->get("/general/{$tenant->id}/change-password")
            ->assertRedirect('/general/login');
    }

    #[Test]
    public function authenticated_user_can_access_change_password_page(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/change-password")
            ->assertOk();
    }

    #[Test]
    public function change_password_requires_current_password(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('general'));
        Filament::setTenant($tenant);

        Livewire::actingAs($user)
            ->test(ChangePassword::class)
            ->set('data.current_password', '')
            ->set('data.password', 'NewPassword123!')
            ->set('data.password_confirmation', 'NewPassword123!')
            ->call('save')
            ->assertHasFormErrors(['current_password']);
    }

    #[Test]
    public function change_password_requires_confirmation_match(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('general'));
        Filament::setTenant($tenant);

        Livewire::actingAs($user)
            ->test(ChangePassword::class)
            ->set('data.current_password', 'anything')
            ->set('data.password', 'NewPassword123!')
            ->set('data.password_confirmation', 'DifferentPassword!')
            ->call('save')
            ->assertHasFormErrors(['password']);
    }

    #[Test]
    public function forgot_password_link_appears_on_login_page(): void
    {
        $this->get('/general/login')
            ->assertOk()
            ->assertSee('Forgot your password?');
    }
}
