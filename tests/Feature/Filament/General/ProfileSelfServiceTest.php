<?php

namespace Tests\Feature\Filament\General;

use App\Filament\General\Pages\ViewProfile;
use App\Models\SystemUser;
use App\Settings\FeatureSettings;
use Filament\Facades\Filament;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class ProfileSelfServiceTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $features = resolve(FeatureSettings::class);
        $features->users_can_add_past_training = true;
        $features->users_can_add_awards = true;
        $features->users_can_add_documents = true;
        $features->users_can_add_past_service = true;
        $features->save();
    }

    #[Test]
    public function view_profile_page_renders_with_section_actions(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(ViewProfile::class)
            ->assertOk()
            ->assertSee('Add Training')
            ->assertSee('Add Award')
            ->assertSee('Add Document')
            ->assertSee('Add Past Service');
    }

    #[Test]
    public function view_profile_displays_user_data(): void
    {
        $user = SystemUser::factory()->withRole()->create([
            'first_name' => 'TestProfileName',
            'surname' => 'TestProfileSurname',
        ]);
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/view-profile")
            ->assertOk()
            ->assertSee('TestProfileName')
            ->assertSee('TestProfileSurname');
    }

    private function setupUserAndPanel(): array
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('general'));
        Filament::setTenant($tenant);

        return [$user, $tenant];
    }
}
