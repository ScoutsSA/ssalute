<?php

namespace Tests\Feature\Filament;

use App\Filament\General\Pages\EditProfile;
use App\Models\SystemUser;
use App\Settings\FeatureSettings;
use Filament\Facades\Filament;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class ProfileTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $features = resolve(FeatureSettings::class);
        $features->users_can_edit_profiles = true;
        $features->users_can_upload_profile_photo = true;
        $features->save();
    }

    // View profile page

    #[Test]
    public function guest_cannot_access_view_profile(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->get($this->viewProfileUrl($user))
            ->assertRedirect('/general/login');
    }

    #[Test]
    public function user_with_active_role_can_view_their_profile(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get($this->viewProfileUrl($user))
            ->assertOk();
    }

    #[Test]
    public function view_profile_displays_the_authenticated_users_data(): void
    {
        $user = SystemUser::factory()->withRole()->create([
            'first_name' => 'Jane',
            'surname' => 'Doe',
            'cellNr' => '0821234567',
        ]);

        $this->actingAs($user)
            ->get($this->viewProfileUrl($user))
            ->assertOk()
            ->assertSee('Jane')
            ->assertSee('Doe')
            ->assertSee('0821234567');
    }

    #[Test]
    public function user_cannot_view_another_users_profile_via_their_tenant_url(): void
    {
        $userA = SystemUser::factory()->withRole()->create();
        $userB = SystemUser::factory()->withRole()->create();

        // User B accesses view-profile under User A's tenant — redirected to their own tenant
        $this->actingAs($userB)
            ->get($this->viewProfileUrl($userA))
            ->assertRedirect($this->viewProfileUrl($userB));
    }

    // Edit profile page

    #[Test]
    public function guest_cannot_access_edit_profile(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->get($this->editProfileUrl($user))
            ->assertRedirect('/general/login');
    }

    #[Test]
    public function user_with_active_role_can_view_edit_profile_page(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $this->actingAs($user)
            ->get($this->editProfileUrl($user))
            ->assertOk();
    }

    #[Test]
    public function user_can_update_their_own_profile(): void
    {
        $user = SystemUser::factory()->withRole()->create([
            'first_name' => 'Old',
            'surname' => 'Name',
            'cellNr' => '0800000000',
        ]);

        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('general'));
        Filament::setTenant($tenant);

        Livewire::actingAs($user)
            ->test(EditProfile::class)
            ->set('data.first_name', 'New')
            ->set('data.surname', 'Name')
            ->set('data.cellNr', '0811111111')
            ->call('save');

        $this->assertDatabaseHas('system_users', [
            'id' => $user->id,
            'first_name' => 'New',
            'cellNr' => '0811111111',
        ]);
    }

    #[Test]
    public function user_cannot_edit_another_users_profile_page(): void
    {
        $userA = SystemUser::factory()->withRole()->create();
        $userB = SystemUser::factory()->withRole()->create();

        // User B accesses edit-profile under User A's tenant — redirected to their own tenant
        $this->actingAs($userB)
            ->get($this->editProfileUrl($userA))
            ->assertRedirect($this->editProfileUrl($userB));
    }

    #[Test]
    public function username_cannot_be_changed_via_edit_profile(): void
    {
        $user = SystemUser::factory()->withRole()->create([
            'username' => 'original@example.com',
            'first_name' => 'Test',
            'surname' => 'User',
        ]);

        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('general'));
        Filament::setTenant($tenant);

        Livewire::actingAs($user)
            ->test(EditProfile::class)
            ->set('data.username', 'hacked@example.com')
            ->call('save');

        $this->assertDatabaseHas('system_users', [
            'id' => $user->id,
            'username' => 'original@example.com',
        ]);
    }

    private function viewProfileUrl(SystemUser $user): string
    {
        return "/general/{$user->roleAttachments()->first()->id}/view-profile";
    }

    private function editProfileUrl(SystemUser $user): string
    {
        return "/general/{$user->roleAttachments()->first()->id}/edit-profile";
    }
}
