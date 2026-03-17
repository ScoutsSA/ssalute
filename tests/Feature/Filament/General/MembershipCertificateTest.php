<?php

namespace Tests\Feature\Filament\General;

use App\Filament\General\Pages\MembershipCertificate;
use App\Models\MembershipCertificate as MembershipCertificateModel;
use App\Models\SystemUser;
use App\Models\SystemUserType;
use App\Settings\FeatureSettings;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class MembershipCertificateTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $features = resolve(FeatureSettings::class);
        $features->users_can_generate_membership_certificate = true;
        $features->save();
    }

    #[Test]
    public function membership_certificate_page_renders_for_member(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->assertOk()
            ->assertSee('Important Notice')
            ->assertSee('Select Information to Display');
    }

    #[Test]
    public function membership_certificate_page_inaccessible_when_feature_disabled(): void
    {
        $features = resolve(FeatureSettings::class);
        $features->users_can_generate_membership_certificate = false;
        $features->save();

        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/membership-certificate")
            ->assertForbidden();
    }

    #[Test]
    public function membership_certificate_page_inaccessible_for_parent_only_role(): void
    {
        $parentRole = SystemUserType::factory()->create([
            'parentHelperRole' => 1,
            'groupRole' => 0,
        ]);

        $user = SystemUser::factory()->withRole($parentRole)->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/membership-certificate")
            ->assertForbidden();
    }

    #[Test]
    public function membership_certificate_page_inaccessible_for_alumni_only_role(): void
    {
        $alumniRole = SystemUserType::factory()->create([
            'alumniRole' => 1,
            'groupRole' => 0,
        ]);

        $user = SystemUser::factory()->withRole($alumniRole)->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/membership-certificate")
            ->assertForbidden();
    }

    #[Test]
    public function member_with_mixed_roles_including_non_parent_can_access(): void
    {
        $parentRole = SystemUserType::factory()->create([
            'parentHelperRole' => 1,
            'groupRole' => 0,
        ]);
        $memberRole = SystemUserType::factory()->create([
            'groupRole' => 1,
        ]);

        $user = SystemUser::factory()
            ->withRole($parentRole)
            ->withRole($memberRole)
            ->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/membership-certificate")
            ->assertOk();
    }

    #[Test]
    public function can_generate_certificate(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->set('selectedFields', ['name', 'ssa_id', 'roles'])
            ->set('includePhoto', false)
            ->call('saveCertificate')
            ->assertNotified('Certificate saved successfully!');

        $this->assertDatabaseHas('membership_certificates', [
            'user_id' => $user->id,
        ]);

        $certificate = MembershipCertificateModel::where('user_id', $user->id)->first();
        $this->assertNotNull($certificate);
        $this->assertEquals(['name', 'ssa_id', 'roles'], $certificate->visible_fields);
        $this->assertNotNull($certificate->uuid);
    }

    #[Test]
    public function generated_certificate_includes_photo_when_selected(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->set('selectedFields', ['name', 'ssa_id'])
            ->set('includePhoto', true)
            ->call('saveCertificate')
            ->assertNotified('Certificate saved successfully!');

        $certificate = MembershipCertificateModel::where('user_id', $user->id)->first();
        $this->assertContains('photo', $certificate->visible_fields);
    }

    #[Test]
    public function updating_certificate_changes_fields_not_creates_new_record(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->set('selectedFields', ['name', 'ssa_id'])
            ->set('includePhoto', false)
            ->call('saveCertificate')
            ->assertNotified('Certificate saved successfully!');

        $originalUuid = MembershipCertificateModel::where('user_id', $user->id)->first()->uuid;

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->set('selectedFields', ['name', 'email', 'roles'])
            ->set('includePhoto', true)
            ->call('saveCertificate')
            ->assertNotified('Certificate saved successfully!');

        $this->assertDatabaseCount('membership_certificates', 1);

        $certificate = MembershipCertificateModel::where('user_id', $user->id)->first();
        $this->assertEquals($originalUuid, $certificate->uuid);
        $this->assertEquals(['name', 'email', 'roles', 'photo'], $certificate->visible_fields);
    }

    #[Test]
    public function existing_certificate_fields_are_loaded_on_mount(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        MembershipCertificateModel::create([
            'user_id' => $user->id,
            'visible_fields' => ['name', 'email', 'photo'],
        ]);

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->assertSet('selectedFields', ['name', 'email'])
            ->assertSet('includePhoto', true);
    }

    #[Test]
    public function public_certificate_page_renders(): void
    {
        $user = SystemUser::factory()->withRole()->create([
            'first_name' => 'CertificateTestName',
            'surname' => 'CertificateTestSurname',
        ]);

        $certificate = MembershipCertificateModel::create([
            'user_id' => $user->id,
            'visible_fields' => ['name', 'ssa_id', 'roles'],
        ]);

        $this->get(route('membership-certificate.show', $certificate->uuid))
            ->assertOk()
            ->assertSee('CertificateTestName')
            ->assertSee('Verified')
            ->assertSee('Member')
            ->assertSee('Scouts South Africa');
    }

    #[Test]
    public function invalid_certificate_uuid_returns_404(): void
    {
        $this->get(route('membership-certificate.show', 'nonexistent-uuid'))
            ->assertNotFound();
    }

    #[Test]
    public function certificate_only_shows_selected_fields(): void
    {
        $user = SystemUser::factory()->withRole()->create([
            'first_name' => 'VisibleName',
            'surname' => 'VisibleSurname',
            'username' => 'hidden@email.test',
            'cellNr' => '0821234567',
        ]);

        $certificate = MembershipCertificateModel::create([
            'user_id' => $user->id,
            'visible_fields' => ['name', 'ssa_id'],
        ]);

        $response = $this->get(route('membership-certificate.show', $certificate->uuid));
        $response->assertOk()
            ->assertSee('VisibleName')
            ->assertDontSee('hidden@email.test')
            ->assertDontSee('0821234567');
    }

    #[Test]
    public function certificate_shows_todays_date(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $certificate = MembershipCertificateModel::create([
            'user_id' => $user->id,
            'visible_fields' => ['name'],
        ]);

        $this->get(route('membership-certificate.show', $certificate->uuid))
            ->assertOk()
            ->assertSee(now()->format('d M Y'));
    }

    #[Test]
    public function can_remove_certificate(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        MembershipCertificateModel::create([
            'user_id' => $user->id,
            'visible_fields' => ['name', 'ssa_id'],
        ]);

        $this->assertDatabaseCount('membership_certificates', 1);

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->call('removeCertificate')
            ->assertNotified('Certificate removed');

        $this->assertDatabaseCount('membership_certificates', 0);
    }

    #[Test]
    public function endorsement_request_sends_email(): void
    {
        Mail::fake();

        $icRole = SystemUserType::factory()->create();
        $icUser = SystemUser::factory()->withRole($icRole)->create([
            'username' => 'ic-rep@test.example',
        ]);

        $settings = resolve(FeatureSettings::class);
        $settings->users_can_request_endorsement = true;
        $settings->international_committee_representative_role_ids = [$icRole->id];
        $settings->save();

        [$user, $tenant] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->callAction('requestEndorsement', [
                'subject' => 'Test Endorsement Subject',
                'description' => 'Test endorsement description',
            ])
            ->assertNotified('Endorsement request sent successfully');

        Mail::assertQueued(\App\Mail\Profile\EndorsementRequestEmail::class);
    }

    #[Test]
    public function endorsement_request_fails_without_configured_roles(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $settings = resolve(FeatureSettings::class);
        $settings->users_can_request_endorsement = true;
        $settings->international_committee_representative_role_ids = [];
        $settings->save();

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->callAction('requestEndorsement', [
                'subject' => 'Test Subject',
                'description' => 'Test description',
            ])
            ->assertNotified('No International Committee Representatives configured');
    }

    #[Test]
    public function membership_certificate_inaccessible_when_user_role_not_in_eligible_list(): void
    {
        $eligibleRole = SystemUserType::factory()->create();
        $otherRole = SystemUserType::factory()->create();

        $settings = resolve(FeatureSettings::class);
        $settings->membership_certificate_eligible_role_ids = [$eligibleRole->id];
        $settings->save();

        $user = SystemUser::factory()->withRole($otherRole)->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/membership-certificate")
            ->assertForbidden();
    }

    #[Test]
    public function membership_certificate_accessible_when_user_role_in_eligible_list(): void
    {
        $eligibleRole = SystemUserType::factory()->create();

        $settings = resolve(FeatureSettings::class);
        $settings->membership_certificate_eligible_role_ids = [$eligibleRole->id];
        $settings->save();

        $user = SystemUser::factory()->withRole($eligibleRole)->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('general'));
        Filament::setTenant($tenant);

        Livewire::actingAs($user)
            ->test(MembershipCertificate::class)
            ->assertOk();
    }

    #[Test]
    public function public_certificate_shows_inactive_when_user_has_no_active_roles(): void
    {
        $user = SystemUser::factory()->create();

        $certificate = MembershipCertificateModel::create([
            'user_id' => $user->id,
            'visible_fields' => ['name'],
        ]);

        $this->get(route('membership-certificate.show', $certificate->uuid))
            ->assertOk()
            ->assertSee('Inactive')
            ->assertSee('This member is no longer active');
    }

    #[Test]
    public function public_certificate_shows_verified_when_user_has_active_roles(): void
    {
        $user = SystemUser::factory()->withRole()->create();

        $certificate = MembershipCertificateModel::create([
            'user_id' => $user->id,
            'visible_fields' => ['name'],
        ]);

        $this->get(route('membership-certificate.show', $certificate->uuid))
            ->assertOk()
            ->assertSee('Verified');
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
